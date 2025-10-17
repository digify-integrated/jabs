<?php
session_start();

require '../api/dbconn.php';

//var_dump($_POST);
//die();


//array(2) { ["remove_id"]=> string(2) "37" ["remove_order_id"]=> string(2) "23" }


if(isset($_POST['remove_id']) && isset($_POST['remove_id']) != NULL){
    //DELETE ITEM 

    
    $query = "DELETE FROM order_details  WHERE id='".$_POST['remove_id'] . "'";
    $result = mysqli_query($conn,$query);
    
   $query = "SELECT order_details.id as product_id, order_details.note as product_note, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.id = ".$_POST['remove_order_id']. " AND orders.table_id = '".$_SESSION['table_id'] . "'";
   // echo $query;
    //$query = "SELECT * from orders, order_details where orders.id = order_details.order_id and orders.table_id = '". $_SESSION['table_id'] ."'";
    //var_dump($query);
    //die();
    $query_run = mysqli_query($conn, $query);
    $count =  mysqli_num_rows($query_run);
    var_dump($count);
    if($count == 0){
        $query = "DELETE FROM orders  WHERE id='".$_POST['remove_order_id'] . "' AND table_id = '". $_SESSION['table_id'] ."'";
        $result = mysqli_query($conn,$query);

       // $query = "DELETE FROM orders  WHERE id='".$_POST['remove_id'] . "' AND table_id = '". $_SESSION['table_id'] ."'";
       // $result = mysqli_query($conn,$query);
       //     $query = "DELETE FROM orders  WHERE id='".$_POST['remove_id'] . "'";
        //    $result = mysqli_query($conn,$query);
    }
}




header("Location: table_details.php?t=" .$_SESSION['table_id']);



?>