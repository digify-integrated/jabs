<?php
session_start();

require '../api/dbconn.php';

$id= $_POST["id"];
$name= $_POST["txtName"];
$email= $_POST["txtEmail"];
$password= $_POST["txtPassword"];
$del = $_GET["del"];

//array(5) { ["id"]=> string(0) "" ["txtName"]=> string(1) "a" ["txtEmail"]=> string(1) "a" ["txtPassword"]=> string(1) "a" ["addbtn"]=> string(0) "" }
//var_dump($_POST);
//die();
//check if exists by name
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($del == 1){
    $query = "DELETE FROM users  WHERE id='$id'";
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
            $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
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
        $query_id = "SELECT * FROM users WHERE id = '$id'";
        $result_id = mysqli_query($conn,$query_id);
        $row_id = $result_id->fetch_assoc();

        //if($row_name['email'] == $email){ //check if name exits in table
        //    $_SESSION['message'] = "danger<>Cannot Update. Already Exists.";
        //}else{
            $query = "UPDATE users SET name = '$name', email = '$email', password='$password'  WHERE id='$id'";
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