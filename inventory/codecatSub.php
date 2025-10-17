<?php
session_start();

require '../api/dbconn.php';

$id= $_POST["id"];
$name= $_POST["txtName"];
$category= $_POST["txtCategory"];
$del = $_GET["del"];
//check if exists by name
$query = "SELECT * FROM inventory_cat_sub WHERE name = '$name'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($del == 1){
    $query = "DELETE FROM inventory_cat_sub  WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        if($result)
        {
            $_SESSION['message'] = "success<>Deleted";
        }
        else
        {
            $_SESSION['message'] = "danger<>An Error Occured";   
        }
}else{
    
    if($id == ""){//add
        //if($result-> num_rows == 0){
            $query = "INSERT INTO inventory_cat_sub (name, cat_id) VALUES ('$name', '$category')";
            
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['message'] = "success<>Added";
                
            }
            else
            {
                $_SESSION['message'] = "danger<>An Error Occured";   
            }
        //}else{

           
        //   $_SESSION['message'] = "danger<>Already Exists.aaa";
            
       // }
    }else{
        $query_id = "SELECT * FROM inventory_cat_sub WHERE id = '$id'";
        $result_id = mysqli_query($conn,$query_id);
        $row_id = $result_id->fetch_assoc();

        //if($row_name['name'] == $name && $row_name['cat_id'] == $id){ //check if name exits in table
        //    $_SESSION['message'] = "danger<>Cannot Update. Already Exists.";
        //}else{
            $query = "UPDATE inventory_cat_sub SET name = '$name', cat_id= '$category' WHERE id='$id'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['message'] = "success<>Updated.";
            }
            else
            {
                $_SESSION['message'] = "danger<>An Error Occured";   
            }
        //}
    }
}
header("Location: cat_sub.php");

?>