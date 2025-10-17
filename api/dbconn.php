<?php 

//date_default_timezone_set('Asia/Tokyo');
//date_default_timezone_set('UTC');
$servername = "localhost";
//$db="resto_app";
//$user       = "root";
//$password   = "";

$db="bitsiwbg_thegoldenlotus";
$user       = "bitsiwbg_thegoldenlotus";
$password   = "BITSBhonnetz2022*2024";


    $conn=mysqli_connect($servername, $user, $password, $db);
    $result = mysqli_query($conn,"SET time_zone = '+08:00'");
    if($result==false)
    {
        die("error query");
    }
    if($conn==false)
    {
        die("connection error");
    }


   



$link = mysqli_connect($servername, $user, $password, $db);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


$mysqli = new mysqli($servername, $user, $password, $db);
$result = $mysqli->query("SET time_zone = '+08:00'");
?>
