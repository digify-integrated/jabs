<?php

 session_start();
 require '../api/dbconn.php';
 $query2 = "INSERT INTO logs (user_id, action) VALUES ('$_SESSION[user_id]', 'logout')";
$result = mysqli_query($conn,$query2);
            

  session_destroy();   // function that Destroys Session 
  header("Location: index.php");
?>