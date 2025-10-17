<?php
session_start();

require '../api/dbconn.php';



//$id= $_POST["item_id"];
//$item= $_POST["txtItem"];
//$uom= $_POST["txtUom"];


$item_id = $_POST['item_id'];
$uom= $_POST['uom'];
//$beginning= $_POST["txtBeginning"];
$beginning = ($_POST['txtBeginning'] == '') ? '0' : $_POST['txtBeginning'];
//$case= $_POST["txtCase"];
//$case = ($_POST['txtCase'] == '') ? '0' : $_POST['txtCase'];
//$additional = $_POST['txtAdditional'];
$additional = ($_POST['txtAdditional'] == '') ? '0' : $_POST['txtAdditional'];
//$out = $_POST['txtOut'];
$out = ($_POST['txtOut'] == '') ? '0' : $_POST['txtOut'];
//$transfer = $_POST['txtTransfer'];
$transfer = ($_POST['txtTransfer'] == '') ? '0' : $_POST['txtTransfer'];
//$actualCount = ($_POST['txtActualCount'] == '') ? '0' : $_POST['txtActualCount'];
//$actualCount = $_POST['txtActualCount'];

//$del = $_GET["del"];
//check if exists by name
//$query = "SELECT * FROM inventory WHERE name = '$name'";
//$result = mysqli_query($conn,$query);
//$row_name = $result->fetch_assoc();

/*if($del == 1){
    $query = "DELETE FROM inventory  WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        if($result)
        {
            $_SESSION['message'] = "success<>Deleted";
        }
        else
        {
            $_SESSION['message'] = "danger<>An Error Occured";   
        }
}else{*/
    //if($id == ""){//add
        //if($result-> num_rows == 0){
            //id	item_id	uom_id	beginning	additional	b_out	transfer	actual_count	datetime	remarks	
            $query = "INSERT INTO `inventory` (`item_id`, `uom_id`, `beginning`, `additional`, `b_out`, `transfer`, `datetime`, `remarks`) 
                                    VALUES ( '$item_id', '$uom', '$beginning', '$additional', '$out', '$transfer', CURRENT_TIMESTAMP, '')";

  //      $query = "INSERT INTO inventory (item_id, uom_id, beginning, additional, b_out, transfer, actual_count) VALUES ($item,$uom, $beginning, $case, $additional, $out, $transfer, $actualCount)";
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
        //    $_SESSION['message'] = "danger<>Already Exists.";
            
        //}
    //}else{
        //$query_id = "SELECT * FROM inventory WHERE id = '$id'";
        //$result_id = mysqli_query($conn,$query_id);
        //$row_id = $result_id->fetch_assoc();

        //if($row_name['name'] == $name){ //check if name exits in table
        //    $_SESSION['message'] = "danger<>Cannot Update. Already Exists.";
        //}else{
            

        //$query = "INSERT INTO `inventory` (`id`, `item_id`, `uom_id`, `beginning`, `additional`, `b_out`, `transfer`, `actual_count`, `datetime`, `remarks`) VALUES (NULL, '$item', '$uom', '$beginning', '$additional', '$out', '$transfer', '$actualCount', CURRENT_TIMESTAMP, '')";

       //     $query = "UPDATE inventory SET name = '$name' WHERE id='$id'";
        //    $result = mysqli_query($conn,$query);
        //    if($result)
        //    {
       //         $_SESSION['message'] = "success<>Updated.";
        //    }
        //    else
        //    {
        //        $_SESSION['message'] = "danger<>An Error Occured";   
        //    }
        //}
    //}
//}
unset($_POST);
$_POST = "";
header("Location: inventory_pos.php");

?>