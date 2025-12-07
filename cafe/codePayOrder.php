<?php
session_start();
require '../api/dbconn.php';

function set_msg($type, $text) {
    $_SESSION['message'] = "{$type}<>{$text}";
}

// ---------- generate payment_reference ----------
$currentDateTime = new DateTime('now');
$currentDate = $currentDateTime->format('mdy');
$pattern = '0' . $currentDate . '%';
$payment_reference = null;

$q = "SELECT payment_reference FROM `payments` WHERE payment_reference LIKE ? ORDER BY payment_reference DESC LIMIT 1";
$stmt = $conn->prepare($q);
$stmt->bind_param("s", $pattern);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if ($row == null) {
    $next = $currentDate . "001";
    $payment_reference = str_pad($next, 9, '0', STR_PAD_LEFT);
} else {
    $next = (int)$row['payment_reference'] + 1;
    $payment_reference = str_pad($next, 9, '0', STR_PAD_LEFT);
}
$stmt->close();

// ---------- session + posted values ----------
$table_id = $_POST['id'] ?? null;
$user_id  = $_SESSION['user_id'] ?? 0;

if (!$table_id) {
    set_msg('danger', 'Missing table id.');
    echo "<script>window.close();</script>";
}

// ---------- get ALL open orders ----------
$order_ids = [];
$q = "SELECT id FROM orders WHERE table_id = ? AND status = 0";
$stmt = $conn->prepare($q);
$stmt->bind_param("s", $table_id);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $order_ids[] = (int)$r['id'];
}
$stmt->close();

if (empty($order_ids)) {
    set_msg('danger', 'No open orders found for this table.');
    echo "<script>window.close();</script>";
}

// ---------- compute subtotal across all orders ----------
$items_subtotal = 0;
$q = "SELECT SUM(od.quantity * p.price) AS items_total
      FROM order_details od
      JOIN products p ON p.id = od.product_id
      WHERE od.order_id IN (" . implode(',', $order_ids) . ")";
$res = $conn->query($q);
if ($row = $res->fetch_assoc()) {
    $items_subtotal = (float)($row['items_total'] ?? 0);
}

// ---------- discounts ----------
$discount_input = isset($_POST['discount']) ? (float)$_POST['discount'] : 0;
$ticketdiscount = isset($_POST['ticketdiscount']) ? (float)$_POST['ticketdiscount'] : 0;

$discount_sc_pwd = min($discount_input, $items_subtotal);

// ---------- compute VAT + service ----------
$vat_exempt     = $discount_sc_pwd / 1.12;
$twenty_percent = $vat_exempt * 0.20;
$vat_sales      = ($items_subtotal - $discount_sc_pwd) / 1.12;
$vat            = $vat_sales * 0.12;
$service_charge = $items_subtotal * 0.10;

$total_due = ($vat_sales + $vat + $vat_exempt + $service_charge) - ($twenty_percent + $ticketdiscount);
if ($total_due < 0) $total_due = 0;

// ---------- payments ----------
$cash  = (float)($_POST['cash_amount'] ?? 0);
$gcash = (float)($_POST['gcash_amount'] ?? 0);
$card  = (float)($_POST['card_amount'] ?? 0);
$ent   = (float)($_POST['ent_amount'] ?? 0);

$amount_received = $cash + $gcash + $card + $ent;

$total_due       = round($total_due, 2);
$amount_received = round($amount_received, 2);


// ---------- VALIDATION ----------
if ($amount_received < $total_due || $amount_received <= 0) {
    set_msg('danger', "Insufficient payment. Received: {$amount_received}, Due: {$total_due}. Transaction not saved.");
    echo "<script>window.close();</script>";
    exit;
}

$change = max(0, round($amount_received - $total_due, 2));

// ---------- transaction ----------
$conn->begin_transaction();

try {
    // insert into payments (just one payment for ALL orders)
    $q = "INSERT INTO `payments`
            (`order_id`, `subtotal`, `total`, `discount_sc_pwd`, `discount_tickets`, 
             `amount_received`, `change`, `created_at`, `payment_reference`, `user_id`)
          VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?)";
    $stmt = $conn->prepare($q);
    $first_order_id = $order_ids[0]; // reference only
    $stmt->bind_param(
        "idddddssi",
        $first_order_id,
        $items_subtotal,
        $total_due,
        $discount_sc_pwd,
        $ticketdiscount,
        $amount_received,
        $change,
        $payment_reference,
        $user_id
    );
    $stmt->execute();
    $stmt->close();

    // update ALL orders for this table → paid
    $q = "UPDATE `orders` 
          SET status = 1, payment_reference = ?, updated_at = CURRENT_TIMESTAMP 
          WHERE table_id = ? AND status = 0";
    $stmt = $conn->prepare($q);
    $stmt->bind_param("ss", $payment_reference, $table_id);
    $stmt->execute();
    $stmt->close();

    // insert payment methods
    if ($cash > 0) {
        $cashNet = max(0, $cash - $change);
        $q = "INSERT INTO `payment_methods` (user_id, table_id, payment_method_id, amount, payment_reference)
              VALUES (?, ?, 1, ?, ?)";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("isds", $user_id, $table_id, $cashNet, $payment_reference);
        $stmt->execute();
        $stmt->close();
    }

    if ($gcash > 0) {
        $gcashRef = trim($_POST['gcash_reference'] ?? '');
        $q = "INSERT INTO `payment_methods` (user_id, table_id, payment_method_id, amount, reference, payment_reference)
              VALUES (?, ?, 2, ?, ?, ?)";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("isdss", $user_id, $table_id, $gcash, $gcashRef, $payment_reference);
        $stmt->execute();
        $stmt->close();
    }

    if ($card > 0) {
        $cardRef = trim($_POST['card_reference'] ?? '');
        $q = "INSERT INTO `payment_methods` (user_id, table_id, payment_method_id, amount, reference, payment_reference)
              VALUES (?, ?, 3, ?, ?, ?)";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("isdss", $user_id, $table_id, $card, $cardRef, $payment_reference);
        $stmt->execute();
        $stmt->close();
    }

    if ($ent > 0) {
        $entRef = trim($_POST['ent_reference'] ?? '');
        $q = "INSERT INTO `payment_methods` (user_id, table_id, payment_method_id, amount, reference, payment_reference)
              VALUES (?, ?, 4, ?, ?, ?)";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("isdss", $user_id, $table_id, $ent, $entRef, $payment_reference);
        $stmt->execute();
        $stmt->close();
    }

    $conn->commit();
    set_msg('success', 'All orders for this table have been paid.');

} catch (Exception $e) {
    $conn->rollback();
    error_log("codePayOrder error: " . $e->getMessage());
    set_msg('danger', 'Error processing payment.');
    echo "<script>window.close();</script>";
}

// ---------- redirect ----------
header("Location: printBill.php?id=" . urlencode($table_id) . "&r=" . urlencode($payment_reference));
exit;
?>
