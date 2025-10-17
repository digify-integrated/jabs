<?php
session_start();

require '../api/dbconn.php';



$id= $_POST["id"];
$name= $_POST["txtName"];
$sname= $_POST["txtSName"];
$cat= $_POST["txtCategory"];
$price= $_POST["txtPrice"];
$description= $_POST["txtDescription"];



$del = $_GET["del"];
//check if exists by name
$query = "SELECT * FROM products  WHERE id = '$id'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($del == 1){
    $query = "DELETE FROM products  WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        if($result)
        {
            $query = "DELETE FROM product_details  WHERE product_id='$id'";
     
            $result = mysqli_query($conn,$query);
            if($result)
            {
            $_SESSION['message'] = "success<>Deleted";
            }
            else
            {
                $_SESSION['message'] = "danger<>An Error Occured";   
            }
        }
}else{
    if($id == ""){//add
        if($result-> num_rows == 0){
            //INSERT INTO `products` (`id`, `name`, `shortname`, `category_id`, `price`, `description`, `created_at`, `updated_at`) VALUES (NULL, '1', '1', '1', '1', '1', NULL, NULL);
            $query = "INSERT INTO products ( `name`, `shortname`, `category_id`, `price`, `description` ) VALUES ('$name','$sname','$cat',$price,'$description')";
            //var_dump($query);
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
            $query = "UPDATE products SET name = '$name', shortname = '$sname', category_id = '$cat', price = $price, description = '$description' WHERE  id=$id";
     
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
header("Location: settings.php");

?>