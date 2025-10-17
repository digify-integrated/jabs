<?php
session_start();
 include '../api/dbconn.php'; 
//var_dump($_POST);
//die();
//array(4) { ["id"]=> string(3) "4_2" ["discount"]=> string(0) "" ["totalAmount"]=> string(6) "240.35" ["totalAmountHidden"]=> string(6) "240.35" }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="./css/stylePrint.css">
        <title></title>
      
        <script type="text/javascript">
            window.print();  
            window.onfocus=function(){
                window.close(); 
            }
        </script>
        <style>
* {
    font-size:12px;
    font-family: 'Arial';
}

td,
th,
tr,
table {
   /* border-top: 1px solid black;*/
    border-collapse: collapse;
}

td.description,
th.description {
    width: 20%;
    max-width: 20%;
}

td.quantity,
th.quantity {
    width: 10%;
    max-width: 10%;
    word-break: break-all;
}

td.price,
th.price {
    width: 60%;
    max-width: 60%;
    word-break: break-all;
    text-align: right;
    align-content: right;
}

.centered {
    text-align: center;
    align-content: center;
    align-items: center;
    justify-content: center;
}



.ticket {
    width: 250px; 
    max-width: 250px; 
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
    body {-webkit-print-color-adjust: exact;}
}


input[type="number"] {
    -webkit-appearance: textfield;
    -moz-appearance: textfield;
    appearance: textfield;
  }
  
  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
  }
  
  .number-input {
    border: 2px solid #ddd;
    display: inline-flex;
  }
  
  .number-input,
  .number-input * {
    box-sizing: border-box;
  }
  
  .number-input button {
    outline:none;
    -webkit-appearance: none;
    background-color: transparent;
    border: none;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    cursor: pointer;
    margin: 0;
    position: relative;
  }
  
  .number-input button:after {
    display: inline-block;
    position: absolute;
    font-family: "Font Awesome 5 Free"; 
    font-weight: 900;
    content: '\f077';
    transform: translate(-50%, -50%) rotate(180deg);
  }
  .number-input button.plus:after {
    transform: translate(-50%, -50%) rotate(0deg);
  }
  
  .number-input input[type=number] {
    font-family: sans-serif;
    max-width: 5rem;
    padding: .5rem;
    border: solid #ddd;
    border-width: 0 2px;
    font-size: 2rem;
    height: 3rem;
    font-weight: bold;
    text-align: center;
  }
</style>
</head>

    <body>
    <div class="ticket">
    <p class="centered">
    <img src="../templates/img/logo2.png" alt="Logo" style="width:60%" ><br>
    <p style=" text-align: center;align-content: center;align-items: center;justify-content: center; font-size: 13px!important;    ">MAHARLIKA HIGHWAY, LOMBOY, TALAVERA, NUEVA ECIJA<br>
TIN NO: 490-693-381-00000
            </p>

          
                   
<?php

if(isset($_GET['r'])){ 
    $table_num = explode("_", $_GET['id']);
}else{
    $table_num = explode("_", $_POST['id']);
}

$query_table = "select name from table_category WHERE id = '".$table_num[0]. "'";
$query_run_table = mysqli_query($conn, $query_table);
$row_table = mysqli_fetch_array($query_run_table);
//var_dump($query_table);
$dateTime ="";
$cashier = "";
$total_items=0;
$discount=0;
$ticketdiscount=0;
$amount_received=0;
$rowdiscount=0;

if(isset($_GET['r'])){ //PRINT BILL
    
   $query = "SELECT orders.user_id, orders.created_at as created_at,  products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products where products.id = order_details.product_id AND orders.id = order_details.order_id AND orders.status = 1 AND orders.table_id = '".$_GET['id'] . "' AND payment_reference = '".$_GET['r'] . "' ";

//$query = "select * from orders where status =1  AND user_id = " . $_SESSION['user_id'] ;
$query2 = "SELECT * from payments WHERE order_id = '" .$_GET['id']."' AND payment_reference = '".$_GET['r'] . "' ";
//echo $query; die();
$query_run_table = mysqli_query($conn, $query2);
$rowdiscount = mysqli_fetch_array($query_run_table);
//$discount= $rowdiscount['discount'];

}else{
    $query = "SELECT orders.user_id, orders.created_at as created_at,  products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products where products.id = order_details.product_id AND orders.id = order_details.order_id AND orders.status = 0 AND orders.table_id = '".$_POST['id'] . "'";
}
 //var_dump($query);
 
 $query_run = mysqli_query($conn, $query);
 
 if(mysqli_num_rows($query_run) > 0){
 
    
    $rowdiscount1 = mysqli_fetch_array($query_run);
    //var_dump($rowdiscount);
    $query_cashier = "SELECT name from users WHERE id = '" .$rowdiscount1['user_id']."'";
    //echo $query;
    $query_run_table = mysqli_query($conn, $query_cashier);
    $row_cashier = mysqli_fetch_array($query_run_table);
    

    $dateTime = $rowdiscount1['created_at'] ?? "";
    $cashier = $row_cashier['name'] ?? "";
?>
  <?php if(isset($_GET['r'])){ ?> Transaction #:<?php echo $_GET['r'] ?? "";?> <br><?php } ?>
        Table # <?php echo $row_table['name'] ." ". $table_num[1];?> 
          <br>Date Time: <?php echo $dateTime;?>
          <br>Cashier: <?php echo $cashier;?> 
          <br> <br> 
          <table style="width:100%;">
              <tbody >
                  <tr style="border-top: 1px  solid black; border-bottom: 1px solid black;">
                  <?php if(isset($_GET['r'])){?>  
                      <td class="description" colspan="3"  ><center>ACKNOWLEDGEMENT RECEIPT</center></td>    
                      <?php }else{?>
                          <td class="description" colspan="3"  ><center>BILL</center></td>    
                      <?php }?>
                  </tr>
<?php

 
 
 
    foreach($query_run as $b){ 
       
        $subtotal = $b['price'] * $b['quantity'];
        $total_items = $total_items + $subtotal;
        $amount_received = $rowdiscount['subtotal'];
        if($amount_received <=0){
            $amount_received = 0;
        }
        $change  = $rowdiscount['change'];
        
        if(isset($_GET['r'])){
            $discount = $rowdiscount['discount_sc_pwd'] ?? 0;
            $ticketdiscount = $rowdiscount['discount_tickets'] ?? 0;
        }else{
            if($_POST['discountBill'] != ""){
                $discount = $_POST['discountBill'] ?? 0;
            }
            if($_POST['ticketBill'] != ""){
                $ticketdiscount = $_POST['ticketBill'] ?? 0;
            }
        }
            ?>
              <tr>
              <td style="width:10%;vertical-align:top;"><?= $b['quantity']; ?> </td>                                
                <td style="text-align:left;" style="width:70%;"><?= $b['product_name']; ?></td>
                
                <td style="width:20%;"><?= number_format((float)$subtotal, 2, ".", ",");  ?></td> 
             
               </tr>
            <?php }  ?>
                    
            </tbody>
            </table>
            
            <hr>
             <?php 

///START
                    //PWD_SC_Discount
                    $vat_exempt = $discount/1.12;
                    $twenty_percent = $vat_exempt*0.20;
                    //$less_twenty = $discount - $twenty_percent;


                    $vat_sales = ($total_items - $discount)/1.12;
                    $vat = $vat_sales*0.12;

                    $total = $vat_sales + $vat;
                    $service_charge = $total_items *0.10;

                    $amount_due = $vat_sales + $vat + $vat_exempt + $service_charge - $twenty_percent - $ticketdiscount;
                    //vat sales + VAT + VAT exempt sales + service charge - pwdsc disc - other disc = amount due
///END
                   /* $service_charge = $total_items * 0.15;
                    $total_amount = $total_items + $service_charge;
                    $vat_sales = $total_amount /  1.12;
                    $vatttt = $vat_sales * 0.12;
                    //var_dump($vat_sales+$vatttt);
                    //var_dump($vatttt); 
                    $less_sc_pwd = $discount * 0.20; //20%
                    //$less_twenty = $discount - $less_sc_pwd;

                    $vat_sales_discount = $less_twenty /  1.12;
                    $vatttt_discount = $vat_sales_discount * 0.12;

                     $a = $vat_sales + $vatttt;
                $b = $vat_sales_discount + $vatttt_discount;
                $c = $a-$b;
                $amountdue = $c - $ticketdiscount;*/
                    
                ?>
            <table style="width:100%;">
            <tr>
                <td style="text-align:right;">SUBTOTAL:</td>
                <td style="text-align: right;">P<?= number_format((float)$total_items, 2, ".", ","); ?></td>
            </tr>
            
              <tr>
                <td style="text-align:right;">VAT Sales:</td>
                <td style="text-align: right;">P<?=  number_format((float)$vat_sales, 2, ".", ","); ?></td>
            </tr>
            <tr>
                <td style="text-align:right;">VAT:</td>
                <td style="text-align: right;">P<?=  number_format((float)$vat, 2, ".", ","); ?></td>
            </tr>
            
            <!--<tr>
                <td style="text-align:right;">Service Charge:</td>
                <td style="text-align: right;">P<?= number_format((float)$service_charge, 2, ".", ",");?></td>
            </tr>-->
            <?php 
            if($discount > 0){
            ?>
            
               <!--<tr>
                    <td style="text-align:right;">Sales PWD/SC:</td>
                    <td style="text-align: right;">P<?=  number_format((float)$discount, 2, ".", ","); ?></td>
                </tr>
                <tr>
                    <td style="text-align:right;">Less 12% VAT:</td>
                    <td style="text-align: right;">(P<?=  number_format((float)$discount-$vat_exempt, 2, ".", ","); ?>)</td>
                </tr>-->
                <tr>
                    <td style="text-align:right;">VAT Exempt:</td>
                    <td style="text-align: right;">P<?=  number_format((float)$vat_exempt, 2, ".", ","); ?></td>
                </tr>
                <!--<tr>
                    <td style="text-align:right;">Less PWD/SC Disc:</td>
                    <td style="text-align: right;">(P<?=  number_format((float)$twenty_percent, 2, ".", ","); ?>)</td>
                </tr>
            <tr>-->
                <td style="text-align:right;">&nbsp;</td>
                <td style="text-align: right;">&nbsp;</td>
            </tr>
         <?php  }  ?>
            <!--<hr>-->
           
            
            <!--<tr>
                <td style="text-align:right;">TOTAL:</td>
                <td style="text-align: right;">P<?=  number_format((float)$vat_sales+$vatttt, 2, ".", ","); ?></td>
            </tr>-->
               
          
            <!--
            <tr>
            <td style="text-align:right;">TOTAL:</td>
                <td style="text-align: right;">P<?=  number_format((float)$total, 2, ".", ","); ?></td>
            </tr>-->

                 <?php /*
            if($discount > 0){
            ?>
            <tr>
                <td style="text-align:right;">VAT Exempt:</td>
                <td style="text-align: right;">P<?=  number_format((float)$vat_exempt, 2, ".", ","); ?></td>
            </tr>
        <?php } */ ?>
         <!--<tr>
                <td style="text-align:right;">&nbsp;</td>
                <td style="text-align: right;">&nbsp;</td>
            </tr>-->
             <tr>
                <td style="text-align:right;">SC:</td>
                <td style="text-align: right;">P<?=  number_format((float)$service_charge, 2, ".", ","); ?></td>
            </tr>
           
            <?php 
            if($discount > 0){
            ?>
            <tr>
                <td style="text-align:right;">Less PWD/Senior Disc:</td>
                <td style="text-align: right;">(P<?=  number_format((float)$twenty_percent, 2, ".", ","); ?>)</td>
            </tr>
            <?php } ?> 
            <?php 
            if($ticketdiscount > 0){
            ?>
            
            <tr>
                <td style="text-align:right;">Less TICKET/S:</td>
                <td style="text-align: right;">(P<?=  number_format((float)$ticketdiscount, 2, ".", ","); ?>)</td>
            </tr>
            <?php } ?>
            <tr>
                <td style="text-align:right;">&nbsp;</td>
                <td style="text-align:right;">&nbsp;</td>
            </tr>
            <tr>
            <td style="text-align:right;">AMOUNT DUE:</td>
                <td style="text-align: right;">P<?=  number_format((float)$amount_due, 2, ".", ","); ?></td>
            </tr>
            <?php if(isset($_GET['r'])){?>  
            <tr>
            <td style="text-align:right;">Amount Recieved:</td>
                <td style="text-align: right;">P<?=  number_format((float)$amount_received, 2, ".", ","); ?></td>
            </tr>
            
            <tr>
                <td style="text-align:right;vertical-align:top;">Payment/s: </td>
                <td style="text-align:right;vertical-align:top;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;"><?php
            //print payment methods here
            //query payment_method tbale here
            $query = "SELECT payment_method_id, amount from payment_methods WHERE table_id = '" .$_GET['id']."' AND payment_reference = '".$_GET['r'] . "'";
            //var_dump($query);
            $query_run = mysqli_query($conn, $query);
            if(mysqli_num_rows($query_run) > 0){
                foreach($query_run as $b){ 
                    if($b['payment_method_id'] == 1){ echo "Cash: P" . number_format((float)$b['amount']+(float)$rowdiscount['change'], 2, ".", ",") . "<br>";}
                    if($b['payment_method_id'] == 2){ echo "Gcash: P" . number_format((float)$b['amount']+(float)$rowdiscount['change'], 2, ".", ",") . "<br>";}
                    if($b['payment_method_id'] == 3){ echo "Card: P" . number_format((float)$b['amount']+(float)$rowdiscount['change'], 2, ".", ",") . "<br>";}
                    if($b['payment_method_id'] == 4){ echo "ENT: P" . number_format((float)$b['amount']+(float)$rowdiscount['change'], 2, ".", ",") . "<br>";}
                    
                }}
            ?></td>
            </tr>
            <tr>
            <td style="text-align: right;">Change:</td>
            
            <td style="text-align: right;">P<?= number_format((float)$rowdiscount['change'], 2, ".", ","); ?></td>
              
    
            <?php  } ?>
            </table>

            <br><br>
            <?php// if(isset($_GET['r'])){?>  
            <p class="centered" style=" font-size:16px;">
                
                Thank you for your purchase.<br>
This is NOT an OFFICIAL RECEIPT
            </p>
            <br><br><br>
            <hr>
            <br>
            <hr>
            
            <?php// }?>
        </div>  
    </body>
</html>

<?php

//header('Location: ticket.php');
}




 ?>

