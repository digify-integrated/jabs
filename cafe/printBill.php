<?php
session_start();
require '../api/dbconn.php';

// --- INPUT HANDLING ---
$table_num = [];
$payment_ref = null;
$table_id_param = null;

if (!empty($_GET['id'])) {
    $table_id_param = $_GET['id'];
    $table_num = explode("_", $table_id_param);
    $payment_ref = $_GET['r'] ?? null;
} elseif (!empty($_POST['id'])) {
    $table_id_param = $_POST['id'];
    $table_num = explode("_", $table_id_param);
} else {
    die("Invalid request. Table not specified.");
}

$escaped_table_id = mysqli_real_escape_string($conn, $table_id_param);
$escaped_payment_ref = $payment_ref ? mysqli_real_escape_string($conn, $payment_ref) : null;

// --- Table info ---
$query_table = "SELECT name FROM table_category WHERE id = '". mysqli_real_escape_string($conn, $table_num[0]) ."'";
$qres = mysqli_query($conn, $query_table);
$row_table = mysqli_fetch_assoc($qres) ?: ['name' => 'Unknown'];

// initialize
$dateTime = "";
$cashier = "";
$total_items = 0.0;
$discount = 0.0;
$ticketdiscount = 0.0;
$amount_received = 0.0;
$change = 0.0;
$payments_row = null;

// --- If printing a paid receipt, load payments row (source of truth) ---
if ($payment_ref) {
    $pq = "SELECT * FROM payments WHERE payment_reference = '$escaped_payment_ref' LIMIT 1";
    $pres = mysqli_query($conn, $pq);
    if ($pres && mysqli_num_rows($pres) > 0) {
        $payments_row = mysqli_fetch_assoc($pres);
        // Use DB values as authoritative
        $total_items     = (float)($payments_row['subtotal'] ?? 0.0);
        $discount        = (float)($payments_row['discount_sc_pwd'] ?? 0.0);
        $ticketdiscount  = (float)($payments_row['discount_tickets'] ?? 0.0);
        $amount_received = (float)($payments_row['amount_received'] ?? 0.0);
        $change          = (float)($payments_row['change'] ?? 0.0);
    } else {
        // If payment reference provided but not found, show message and exit
        die("Payment reference not found.");
    }
}

// --- Build query to fetch order items (for either preview or paid receipt) ---
// If paid receipt: fetch items for order(s) that match table_id + payment_reference (status=1).
// If preview: fetch items for unpaid order (status=0) of that table.
if ($payment_ref) {
    $items_q = "
        SELECT o.user_id, o.created_at, p.name AS product_name, od.quantity, p.price, o.id AS order_id
        FROM orders o
        JOIN order_details od ON od.order_id = o.id
        JOIN products p ON p.id = od.product_id
        WHERE o.status = 1
          AND o.table_id = '$escaped_table_id'
          AND o.payment_reference = '$escaped_payment_ref'
    ";
} else {
    // preview (before payment)
    $escaped_post_id = mysqli_real_escape_string($conn, $_POST['id'] ?? $table_id_param);
    $items_q = "
        SELECT o.user_id, o.created_at, p.name AS product_name, od.quantity, p.price, o.id AS order_id
        FROM orders o
        JOIN order_details od ON od.order_id = o.id
        JOIN products p ON p.id = od.product_id
        WHERE o.status = 0
          AND o.table_id = '$escaped_post_id'
    ";
}

$items_res = mysqli_query($conn, $items_q);
if (!$items_res) {
    die("Failed to fetch order items.");
}

// For preview (not yet paid), if payments_row is null we must compute discount values from posted fields
if (!$payment_ref) {
    // read posted discount fields if available (from Print Bill modal)
    $discount = isset($_POST['discountBill']) && $_POST['discountBill'] !== '' ? (float)$_POST['discountBill'] : 0.0;
    $ticketdiscount = isset($_POST['ticketBill']) && $_POST['ticketBill'] !== '' ? (float)$_POST['ticketBill'] : 0.0;
}

// --- Determine cashier and created_at from first item if available ---
$row_first = mysqli_fetch_assoc($items_res);
if ($row_first) {
    $dateTime = $row_first['created_at'] ?? "";
    $uid = $row_first['user_id'] ?? 0;
    $cashier_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM users WHERE id = '".mysqli_real_escape_string($conn, $uid)."'"));
    $cashier = $cashier_row['name'] ?? "N/A";
    // reset pointer so we can iterate again
    mysqli_data_seek($items_res, 0);
}

// --- Sum total_items from DB rows (use DB subtotal if payments_row exists) ---
if ($payments_row) {
    // we already set $total_items from payments_row['subtotal']
    // but still iterate to display each line item below
} else {
    // compute total_items by summing item rows
    $total_items = 0.0;
    foreach ($items_res as $row_item) {
        $total_items += ((float)$row_item['price'] * (float)$row_item['quantity']);
    }
    // reset pointer for display
    mysqli_data_seek($items_res, 0);
}

// --- Compute VAT / SC / amount due consistently (same formula as you defined) ---
$vat_exempt     = $discount / 1.12;
$twenty_percent = $vat_exempt * 0.20;
$vat_sales      = ($total_items - $discount) / 1.12;
$vat            = $vat_sales * 0.12;
$service_charge = $total_items * 0.10; // 10% service charge per your formula
$amount_due     = ($vat_sales + $vat + $vat_exempt + $service_charge) - ($twenty_percent + $ticketdiscount);
if ($amount_due < 0) $amount_due = 0.0;

// If payments_row exists but the stored 'total' differs from recomputed amount_due, prefer the stored 'total' for display of "TOTAL DUE"
if ($payments_row && isset($payments_row['total'])) {
    $stored_total = (float)$payments_row['total'];
    // Use stored_total as authoritative for the Amount Due displayed on paid receipts.
    $amount_due_display = $stored_total;
} else {
    $amount_due_display = $amount_due;
}

// --- Ready to render ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Receipt</title>
    <link rel="stylesheet" href="./css/stylePrint.css">
    <style>
        * { font-size:12px; font-family: Arial; }
        td, th, tr, table { border-collapse: collapse; }
        .ticket { width: 250px; max-width: 250px; }
        .centered { text-align: center; }
        @media print { .hidden-print { display:none !important; } body { -webkit-print-color-adjust: exact; } }
    </style>
    <script>
        window.print();
        window.onfocus = function(){ window.close(); }
    </script>
</head>
<body>
<div class="ticket">
    <p class="centered"><img src="../templates/img/logo2.png" alt="Logo" style="width:60%"></p>
    <p style="text-align:center;font-size:13px">
        MAHARLIKA HIGHWAY, LOMBOY, TALAVERA, NUEVA ECIJA<br>
        TIN NO: 490-693-381-00000
    </p>

    <?php if (mysqli_num_rows($items_res) > 0): ?>
        <?php // Re-fetch first row to get date/cashier if not set above (defensive) ?>
        <?php if (empty($dateTime) || empty($cashier)) {
            $tmp = mysqli_fetch_assoc($items_res);
            if ($tmp) {
                $dateTime = $tmp['created_at'] ?? $dateTime;
                $uid = $tmp['user_id'] ?? $uid;
                $rowc = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM users WHERE id = '".mysqli_real_escape_string($conn, $uid)."'"));
                $cashier = $rowc['name'] ?? $cashier;
            }
            mysqli_data_seek($items_res, 0);
        } ?>

        <?php if ($payment_ref): ?>
            Transaction #: <?= htmlspecialchars($payment_ref) ?><br>
        <?php endif; ?>

        Table # <?= htmlspecialchars($row_table['name'] . " " . ($table_num[1] ?? "")) ?><br>
        Date Time: <?= htmlspecialchars($dateTime) ?><br>
        Cashier: <?= htmlspecialchars($cashier) ?><br><br>

        <table style="width:100%;">
            <tr style="border-top:1px solid black;border-bottom:1px solid black;">
                <td colspan="3" class="centered"><?= $payment_ref ? "ACKNOWLEDGEMENT RECEIPT" : "BILL" ?></td>
            </tr>

            <?php foreach ($items_res as $item): 
                $line_sub = ((float)$item['price']) * ((float)$item['quantity']);
            ?>
            <tr>
                <td style="width:10%;"><?= htmlspecialchars($item['quantity']) ?></td>
                <td style="width:70%;"><?= htmlspecialchars($item['product_name']) ?></td>
                <td style="width:20%;text-align:right;"><?= number_format($line_sub, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <hr>

        <table style="width:100%;">
            <tr><td style="text-align:right;">SUBTOTAL:</td><td style="text-align:right;">P<?= number_format($total_items,2) ?></td></tr>
            <tr><td style="text-align:right;">VAT Sales:</td><td style="text-align:right;">P<?= number_format($vat_sales,2) ?></td></tr>
            <tr><td style="text-align:right;">VAT:</td><td style="text-align:right;">P<?= number_format($vat,2) ?></td></tr>
            <tr><td style="text-align:right;">SC:</td><td style="text-align:right;">P<?= number_format($service_charge,2) ?></td></tr>

            <?php if ($discount > 0): ?>
            <tr><td style="text-align:right;">Less PWD/Senior Disc:</td><td style="text-align:right;">(P<?= number_format($twenty_percent,2) ?>)</td></tr>
            <?php endif; ?>

            <?php if ($ticketdiscount > 0): ?>
            <tr><td style="text-align:right;">Less TICKET/S:</td><td style="text-align:right;">(P<?= number_format($ticketdiscount,2) ?>)</td></tr>
            <?php endif; ?>

            <tr><td style="text-align:right;"><strong>AMOUNT DUE:</strong></td><td style="text-align:right;"><strong>P<?= number_format($amount_due_display,2) ?></strong></td></tr>

            <?php if ($payment_ref): ?>
                <tr><td style="text-align:right;">Amount Received:</td><td style="text-align:right;">P<?= number_format($amount_received,2) ?></td></tr>

                <tr><td colspan="2" style="text-align:right;">
                    <?php
                        $pay_q = "
                            SELECT payment_method_id, amount, reference
                            FROM payment_methods
                            WHERE table_id = '".mysqli_real_escape_string($conn, $table_id_param)."'
                              AND payment_reference = '".mysqli_real_escape_string($conn, $payment_ref)."'
                        ";
                        $pay_run = mysqli_query($conn, $pay_q);
                        while ($pm = mysqli_fetch_assoc($pay_run)) {
                            $pm_id = (int)$pm['payment_method_id'];
                            switch ($pm_id) {
                                case 1: $label = "Cash"; break;
                                case 2: $label = "Gcash"; break;
                                case 3: $label = "Card"; break;
                                case 4: $label = "ENT"; break;
                                default: $label = "Other"; break;
                            }
                            echo htmlspecialchars($label) . ": P" . number_format((float)$pm['amount'],2);
                            echo "<br>";
                        }
                    ?>
                </td></tr>

                <tr><td style="text-align:right;">Change:</td><td style="text-align:right;">P<?= number_format($change,2) ?></td></tr>
            <?php endif; ?>
        </table>

        <br><br>
        <p class="centered" style="font-size:16px;">
            Thank you for your purchase.<br>This is NOT an OFFICIAL RECEIPT
        </p>

    <?php else: ?>
        <p>No items found for this table/order.</p>
    <?php endif; ?>
</div>
</body>
</html>
