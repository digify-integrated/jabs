<?php
    session_start();

    require '../api/dbconn.php';

    $username_login = $_POST['username']; 
    $password_login = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = '$username_login' AND password = '$password_login' ";
    $result = mysqli_query($conn,$query);
    
    if($result-> num_rows != 0){
        $row = $result->fetch_assoc();
        $_SESSION['user_id']=$row['id'];
        $_SESSION['name']=$row['name'];
        //$_SESSION['usertype']=$row['usertype'];

        $query2 = "INSERT INTO logs (user_id, action) VALUES ('$_SESSION[user_id]', 'login')";
        $result = mysqli_query($conn,$query2);
        
        //header("Location: accounts.php");
//var_dump($row);
        //if($row['usertype']=='admin' || $row['usertype']=='user'){   
            header("Location: tables.php");
        //}
        
    }else{
        $_SESSION['message'] = "danger<>Username or Password is Incorrect.";
        header("Location: index.php");
    }
  

?>
 