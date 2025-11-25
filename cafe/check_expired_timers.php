<?php
require '../api/dbconn.php';

// find running timers that have passed end_time
$q = "SELECT id, table_id FROM table_timers WHERE status='running' AND end_time <= NOW() LIMIT 1";
$res = mysqli_query($conn, $q);
if ($res && mysqli_num_rows($res) > 0) {
    // mark them expired (affects all that have passed)
    mysqli_query($conn, "UPDATE table_timers SET status='expired' WHERE status='running' AND end_time <= NOW()");
    echo "ALERT";
} else {
    echo "OK";
}
