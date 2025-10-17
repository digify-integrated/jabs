<?php
    session_start();

    require '../api/dbconn.php';

    $username_login = $_POST['username']; 
    $password_login = $_POST['password'];
    
    $query = "SELECT * FROM accounts WHERE user_name = '$username_login' AND password = '$password_login' ";
    $result = mysqli_query($conn,$query);
    
    if($result-> num_rows != 0){
        $row = $result->fetch_assoc();
        $_SESSION['account_id']=$row['id'];
        $_SESSION['name']=$row['name'];
       
            header("Location: inventory.php");
       
        
    }else{
        $_SESSION['message'] = "danger<>Username or Password is Incorrect.";
       header("Location: index.php");
    }
    var_dump( $_SESSION['message']);
  

?>
 