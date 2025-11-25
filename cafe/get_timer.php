<?php
require '../api/dbconn.php';
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

if(!isset($_GET['table_id'])){
    echo json_encode(["seconds" => 0]);
    exit;
}

$table_id = $_GET['table_id'];

// Fetch end_time from table_timers
$query = "SELECT end_time FROM table_timers WHERE table_id='$table_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row && $row['end_time'] != null) {
    $now = time();
    $end = strtotime($row['end_time']);
    $seconds = max(0, $end - $now);
    echo json_encode([
        "seconds" => $seconds,
        "end_time" => $row['end_time']
    ]);
} else {
    // No timer exists yet
    echo json_encode(["seconds" => 0, "end_time" => null]);
}
?>
