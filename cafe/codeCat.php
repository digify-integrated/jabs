<?php
session_start();

require '../api/dbconn.php';

$id= $_POST["id"];
$name= $_POST["txtName"];

$del = $_GET["del"];
//check if exists by name
$query = "SELECT * FROM product_categories WHERE name = '$name'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($del == 1){
    $query = "DELETE FROM product_categories  WHERE id='$id'";
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
        if($result-> num_rows == 0){
            $query = "INSERT INTO product_categories (name) VALUES ('$name')";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['message'] = "success<>Added";
                
            }
            else
            {
                $_SESSION['message'] = "danger<>An Error Occured";   
            }
        }else{
            $_SESSION['message'] = "danger<>Already Exists.";
            
        }
    }else{
        $query_id = "SELECT * FROM product_categories WHERE id = '$id'";
        $result_id = mysqli_query($conn,$query_id);
        $row_id = $result_id->fetch_assoc();

        if($row_name['name'] == $name){ //check if name exits in table
            $_SESSION['message'] = "danger<>Cannot Update. Already Exists.";
        }else{
            $query = "UPDATE product_categories SET name = '$name'  WHERE id='$id'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['message'] = "success<>Updated.";
            }
            else
            {
                $_SESSION['message'] = "danger<>An Error Occured";   
            }
        }
    }
}
header("Location: settings.php");

?>