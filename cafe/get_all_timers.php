<?php
include '../api/dbconn.php';
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

$result = [];

$query = "SELECT table_id, end_time FROM table_timers";
$q_run = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($q_run)) {
    // Split table_id: "3_4" => [category_id, table_number]
    $parts = explode('_', $row['table_id']);
    $category_id = $parts[0];
    $table_number = $parts[1] ?? null;

    // Get table category name
    $query_cat = "SELECT name FROM table_category WHERE id = '$category_id' LIMIT 1";
    $q_cat_run = mysqli_query($conn, $query_cat);
    $cat_row = mysqli_fetch_assoc($q_cat_run);
    $table_name = $cat_row ? $cat_row['name'] : "Unknown";

    // Calculate remaining seconds dynamically
    $seconds_remaining = 0;
    if (!empty($row['end_time'])) {
        $seconds_remaining = max(0, strtotime($row['end_time']) - time());
    }

    // Store in result
    $result[$row['table_id']] = [
        'seconds' => $seconds_remaining,
        'table_name' => $table_name,
        'table_number' => $table_number
    ];
}

echo json_encode($result);
?>
