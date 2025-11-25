<?php
require '../api/dbconn.php';
date_default_timezone_set('Asia/Manila');

if(!isset($_POST['table_id'])){
    echo "Missing table_id";
    exit;
}

$table_id = $_POST['table_id'];

// Check if this is a delete request
if(isset($_POST['delete']) && $_POST['delete'] == 1){
    $query = "DELETE FROM table_timers WHERE table_id='$table_id'";
    if(mysqli_query($conn, $query)){
        echo "Timer deleted";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}

// Otherwise, normal save/update
if(!isset($_POST['seconds'])){
    echo "Missing seconds";
    exit;
}

$seconds = intval($_POST['seconds']);
$end_time = date("Y-m-d H:i:s", time() + $seconds);

$query = "INSERT INTO table_timers (table_id, end_time)
          VALUES ('$table_id', '$end_time')
          ON DUPLICATE KEY UPDATE end_time='$end_time'";

if(mysqli_query($conn, $query)){
    echo "Saved";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
