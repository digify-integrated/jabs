<?php
session_start();

require '../api/dbconn.php';


$currentDateTime = new DateTime('now');
$currentDateTime = $currentDateTime->format('mdy');

$query = "SELECT payment_reference FROM `payments` WHERE payment_reference LIKE '0".$currentDateTime. "%' ORDER BY payment_reference desc LIMIT 1;";

if ( $result = mysqli_query($conn,$query)) {
    $row = $result->fetch_assoc();
    if($row == NULL){
        $n = 0;
        $currentTicketNumber = $currentDateTime . str_pad($n + 1, 3, 0, STR_PAD_LEFT);
       
        //echo $currentTicketNumber;
    }else{
        $currentTicketNumber = $row['payment_reference']+1;
    }
    $currentTicketNumber = str_pad($currentTicketNumber, 9, 0, STR_PAD_LEFT);
}

$table_id = $_POST["id"];
if(empty($_POST["discount"])){ $discount = 0;} else{$discount = floatval($_POST["discount"]);}
if(empty($_POST["ticketdiscount"])){ $ticketdiscount = 0;} else{$ticketdiscount = floatval($_POST["ticketdiscount"]);}
$amountReceived = floatval($_POST["totalAmount"]);
$total = floatval($_POST["totalAmountHidden"]);
if(empty($_POST["change"])){ $change = 0;} else{$change = floatval($_POST["change"]);}
$payment_reference =$currentTicketNumber;
$subtotal = (int)  $_POST["cash_amount"] + (int)  $_POST["gcash_amount"]+ (int) $_POST["card_amount"] + (int) $_POST["ent_amount"];  //add all payments
if($subtotal == 0){
    $subtotal =  0 - $amountReceived;
}
$user_id =  $_SESSION['user_id'];
$query ="INSERT INTO `payments` (`order_id`, `subtotal`, `total`, `discount_sc_pwd`,`discount_tickets` , `amount_received`, `change`, `created_at`,  `payment_reference` , `user_id`) VALUES ( '$table_id', '$subtotal','$total', '$discount','$ticketdiscount', '$amountReceived','$change', CURRENT_TIMESTAMP, '$payment_reference' , '$user_id');";

$result = mysqli_query($conn,$query);
if($result){
    $query = "UPDATE orders SET status = 1, payment_reference = '$payment_reference', updated_at=CURRENT_TIMESTAMP   WHERE table_id = '$table_id' AND status =0";
    //var_dump($query);
    //die();
    
        $result = mysqli_query($conn,$query);
        if($result){
        if(empty($_POST["cash_amount"])){ } else{
            $cash = $_POST["cash_amount"] - $change;
           $query = "INSERT INTO `payment_methods` (`user_id`, `table_id`, `payment_method_id`, `amount`, `payment_reference`) VALUES ('$user_id', '$table_id', 1, '$cash', '$payment_reference')";
           
           $result = mysqli_query($conn,$query);
        }
        if(empty($_POST["gcash_amount"])){ } else{
            $gcash = $_POST["gcash_amount"]; $gcash_reference=$_POST["gcash_reference"];
            $query = "INSERT INTO `payment_methods` (`user_id`, `table_id`, `payment_method_id`, `amount`, `reference`, `payment_reference`) VALUES ('$user_id','$table_id', 2, '$gcash', '$gcash_reference', '$payment_reference')";
            var_dump($query);
           $result = mysqli_query($conn,$query);
        }
        if(empty($_POST["card_amount"])){ } else{
            $card = $_POST["card_amount"]; $card_reference=$_POST["card_reference"];
            $query = "INSERT INTO `payment_methods` (`user_id`,`table_id`, `payment_method_id`, `amount`, `reference`, `payment_reference`) VALUES ('$user_id','$table_id', 3, '$card', '$card_reference', '$payment_reference')";
           $result = mysqli_query($conn,$query);
        }
        if(empty($_POST["ent_amount"])){ } else{
            $ent = $_POST["ent_amount"]; $ent_reference=$_POST["end_reference"];
            $query = "INSERT INTO `payment_methods` (`user_id`, `table_id`, `payment_method_id`, `amount`, `reference`, `payment_reference`) VALUES ('$user_id', '$table_id', 4, '$ent', '$ent_reference', '$payment_reference')";
           $result = mysqli_query($conn,$query);
        }

        if($result)
        {
            $_SESSION['message'] = "success<>PAID.";
        }
        else
        {
            $_SESSION['message'] = "danger<>An Error Occured";   
        }
        }
    }


//header("Location: table_details.php?t=" .$_SESSION['table_id']);
if( $subtotal > 0){
header("Location: printBill.php?id=" .$table_id . "&r=" . $currentTicketNumber);
}else{
    ?> 
     <script type="text/javascript">
        
       // window.onfocus=function(){
            window.close();
       // }
        </script>
    <?php
}
//echo '<script>window.location.href="welcome.php";
//</script>';
//http://localhost/restoran/cafe/printBill.php?id=2_7


?>
 