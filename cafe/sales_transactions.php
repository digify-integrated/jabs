<?php
include 'header.php';
ob_start();
date_default_timezone_set('Asia/Singapore');

$yesterday = date('Y-m-d 09:00:00', strtotime('-1 days'));
$endDate = date('Y-m-d H:i:s');
$date = date('Y-m-d ') . "00:00:00";
$d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
$midnight = $d->getTimestamp();
$timeNow = time();
$diff = abs($midnight - $timeNow) / 3600;

if ($diff >= 6) {
    $startDate = date('Y-m-d') . " 09:00:00";
} elseif ($diff <= 4) {
    $startDate = $yesterday;
} else {
    $startDate = $endDate;
}

if (isset($_POST['txtPassword'])) {
    $pass = $_POST['txtPassword'];
    $query = "SELECT * FROM users WHERE id='1'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] !== $pass) {
            echo "<script>alert('Incorrect Password.');</script>";
        } else {
            $paymentRef = $_POST['id'];
            mysqli_query($conn, "UPDATE orders SET status = 3 WHERE payment_reference='$paymentRef'");
            mysqli_query($conn, "UPDATE payments SET payment_method_id = '1' WHERE payment_reference='$paymentRef'");
            unset($_POST['txtPassword']);
        }
    } else {
        echo "<script>alert('Incorrect Password.');</script>";
    }
}

if (isset($_GET['c'])) {
    $paymentRef = $_GET['c'];
    mysqli_query($conn, "UPDATE orders SET status = 1 WHERE payment_reference='$paymentRef'");
    mysqli_query($conn, "UPDATE payments SET payment_method_id = '0' WHERE payment_reference='$paymentRef'");
    echo "<script>window.location.href='sales_transactions.php';</script>";
}

$query = "
    SELECT payment_reference, table_id, status, created_at, user_id 
    FROM orders 
    WHERE created_at BETWEEN '$startDate' AND '$endDate'
    GROUP BY payment_reference
";
$query_run = mysqli_query($conn, $query);
?>

<div class="py-5 bg-dark mb-5" style="min-height: 100vh;">
    <div>
        <div class="ps-5 pe-5 pt-2" style="background-color: ghostwhite;">
            <div class="text-center">
                <h1 class="section-title ff-secondary text-center text-primary fw-normal">Transactions</h1>
                <h4 class="mb-1">&nbsp;</h4>
            </div>

            <?php if (mysqli_num_rows($query_run) > 0): ?>
                <table id="report" class="table table-striped table-bordered" style="width:100%;" border="1">
                    <thead>
                        <tr>
                            <th class="text-center">Date Time</th>
                            <th class="text-center" style="width:15%;">Reference</th>
                            <th class="text-center">Table</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($query_run as $a): ?>
                            <?php if ($a['payment_reference'] && $a['created_at']): ?>
                                <?php
                                $table_num = explode("_", $a['table_id']);
                                $table_query = "SELECT name FROM table_category WHERE id = '{$table_num[0]}'";
                                $table_result = mysqli_query($conn, $table_query);
                                $row_table = mysqli_fetch_array($table_result);

                                $user_query = "SELECT name FROM users WHERE id = '{$a['user_id']}'";
                                $user_result = mysqli_query($conn, $user_query);
                                $row_cashier = mysqli_fetch_array($user_result);

                                $statusMap = [
                                    0 => "<span style='color: blue;'>Unpaid</span>",
                                    1 => "<span style='color: green;'>Paid</span>",
                                    2 => "<span style='color: red;'>Cancelled</span>",
                                    3 => "<span style='color: red;'>Void</span>"
                                ];
                                $status = $statusMap[$a['status']] ?? "";
                                $urlPrint = "printBill.php?id={$a['table_id']}&r={$a['payment_reference']}";
                                $modalId = 'editVoid' . $a['payment_reference'];
                                ?>

                                <tr>
                                    <td class="text-center"><?= $a['created_at']; ?></td>
                                    <td class="text-center"><?= $a['payment_reference']; ?></td>
                                    <td><?= $row_table['name'] . ' ' . $table_num[1]; ?></td>
                                    <td><?= $status; ?></td>
                                    <td><?= $row_cashier['name']; ?></td>
                                    <td>
                                        <?php if ($a['status'] != 3): ?>
                                            <a class="btn btn-dark" onclick="window.open('<?= $urlPrint ?>','print_popup','width=1000,height=800');">Print Receipt</a>
                                            <a class="btn btn-danger" data-toggle="modal" data-target="#<?= $modalId; ?>">VOID</a>

                                            <div class="modal fade" id="<?= $modalId; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Void Transaction # (<?= $a['payment_reference']; ?>)</h5>
                                                        </div>
                                                        <form method="POST">
                                                            <input type="hidden" name="id" value="<?= $a['payment_reference']; ?>">
                                                            <div class="modal-body">
                                                                Enter Password:
                                                                <input class="form-control" type="password" name="txtPassword" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-dark btn-sm" type="button" data-dismiss="modal">Cancel</button>
                                                                <input type="submit" class="btn btn-danger btn-sm" value="VOID">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a class="btn btn-warning" href="?c=<?= $a['payment_reference']; ?>">Undo Void</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h5>No Record Found</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
ob_end_flush();
?>
