<?php
session_start();

require '../api/dbconn.php';

$id= $_POST["id"];
$name= $_POST["txtName"];
$seat= $_POST["txtTable"];
$del = $_GET["del"];
//check if exists by name
$query = "SELECT * FROM table_category WHERE name = '$name'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($del == 1){
    $query = "DELETE FROM table_category  WHERE id='$id'";
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
            $query = "INSERT INTO table_category (name, table_counts) VALUES ('$name', '$seat')";
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
        $query_id = "SELECT * FROM table_category WHERE id = '$id'";
        $result_id = mysqli_query($conn,$query_id);
        $row_id = $result_id->fetch_assoc();

        if($row_name['user_name'] == $name){ //check if name exits in table
            $_SESSION['message'] = "danger<>Cannot Update. Already Exists.";
        }else{
            $query = "UPDATE table_category SET name = '$name', table_counts = '$seat'  WHERE id='$id'";
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