<?php

 session_start();
 require '../api/dbconn.php';
//echo "<pre>";
//var_dump($_SESSION['table_id']);
//var_dump($_POST);
//var_dump($_GET['t']);
$new_table = $_GET['t'];
$old_table=$_SESSION['table_id'];
//die();

$query = "UPDATE orders SET table_id = '$new_table' WHERE table_id='$old_table'";
$result = mysqli_query($conn,$query);            
if($result){
  //session_destroy();   // function that Destroys Session 
  header("Location:table_details.php?t=". $new_table);
  //http://localhost/restoran/cafe/table_details.php?t=2_1#ChangeTable
}
?>