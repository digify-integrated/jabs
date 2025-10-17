<?php
    session_start();

    require '../api/dbconn.php';

    //echo "<pre>";

//var_dump($_SESSION);
$table_id= $_SESSION['table_id'];
$user_id = $_SESSION["user_id"];
//add lng ng add

$query = "INSERT INTO orders (user_id, status, table_id) VALUES ('$user_id', 0, '$table_id')";
$result = mysqli_query($conn,$query);
//get ID
$query = "SELECT * FROM orders WHERE table_id = '$table_id' AND status = 0 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();
$order_id=$row_name['id'];

foreach($_SESSION["shopping_cart"] as $key => $value){
    //$count++;
    $product_id= $value["product_id"];
    $quantity=$value["product_quantity"];
    $note=$value["product_note"];
    $query = "INSERT INTO order_details (order_id, product_id, quantity, note ) VALUES ('$order_id','$product_id', '$quantity', '$note')";
    $result = mysqli_query($conn,$query);
    
}
unset($_SESSION["shopping_cart"]);

header("Location: table_details.php?t=" .$_SESSION['table_id']);


?>
 