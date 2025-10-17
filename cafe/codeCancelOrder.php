<?php
    session_start();

    require '../api/dbconn.php';


    $order_id= $_POST['id'];
    $query = "DELETE FROM orders  WHERE id='".$order_id . "' AND table_id = '". $_SESSION['table_id'] ."'";
    $result = mysqli_query($conn,$query);


    $query = "DELETE FROM order_details  WHERE order_id='".$order_id . "'";
    $result = mysqli_query($conn,$query);
    //var_dump($_POST['id']);
    //die();
    /*
$order_id= $_POST['id'];
//check if exists by name
$query = "SELECT * FROM orders WHERE id = '$order_id'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($row_name == NULL){ //add
   // $query = "INSERT INTO orders (user_id, status, table_id) VALUES ('$user_id', 0, '$table_id')";
   // $result = mysqli_query($conn,$query);
    
}else{
    $query = "UPDATE orders SET status = 2 WHERE id=$order_id";
    $result = mysqli_query($conn,$query);
    if($result)
    {
        $_SESSION['message'] = "success<>Canceled.";
    }
    else
    {
        $_SESSION['message'] = "danger<>An Error Occured";   
    }
}*/

header("Location: table_details.php?t=" .$_SESSION['table_id']);


?>
 