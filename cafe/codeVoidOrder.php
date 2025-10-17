<?php
    session_start();

    require '../api/dbconn.php';

//BY TRABLE ID

//var_dump($_POST);
    //die();
$table_id= $_POST['id'];
//check if exists by name
$query = "SELECT * FROM orders WHERE table_id = '$table_id'";
$result = mysqli_query($conn,$query);
$row_name = $result->fetch_assoc();

if($row_name == NULL){ //add
   // $query = "INSERT INTO orders (user_id, status, table_id) VALUES ('$user_id', 0, '$table_id')";
   // $result = mysqli_query($conn,$query);
    
}else{
    $query = "UPDATE orders SET status = 2 WHERE table_id = '$table_id'";
//var_dump($query);
    $result = mysqli_query($conn,$query);
    if($result)
    {
        $_SESSION['message'] = "success<>VOID.";
    }
    else
    {
        $_SESSION['message'] = "danger<>An Error Occured";   
    }
}

header("Location: table_details.php?t=" .$_SESSION['table_id']);


?>
 