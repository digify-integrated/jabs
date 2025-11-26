<?php
session_start();
 include '../api/dbconn.php'; 
    //var_dump($_SESSION);
//if(isset($_SESSION) && isset($_SESSION['user_id']) != NULL && isset($_SESSION['query']) != NULL){
    if(isset($_SESSION) && isset($_SESSION['user_id']) != NULL ){

$cashier="";    
//$query = $_SESSION['query'];

$dateTime = $_SESSION['datetime'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$cash = 0;
$gcash = 0;
$card = 0;
$ent = 0;
$cash_count = 0;
$gcash_count = 0;
$card_count = 0;
$ent_count = 0;
$change = 0;

$void=0;
$void_count=0;

$query = "SELECT SUM(total) as void_amount FROM payments where payment_method_id = 1 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
$query_run_table = mysqli_query($conn, $query);
$row_table = mysqli_fetch_array($query_run_table);
$void=$row_table['void_amount'];


$query = "select COUNT(id) as count FROM payments where payment_method_id = 1 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
$query_run_table = mysqli_query($conn, $query);
$row_table = mysqli_fetch_array($query_run_table);
$void_count=$row_table['count'];


//foreach($query_run as $a){ 
   $query = "SELECT SUM(amount) as amount FROM payment_methods WHERE payment_method_id = 1 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $cash=$row_table['amount'];
  

   $query = "select COUNT(id) as count FROM payment_methods WHERE payment_method_id = 1 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $cash_count=$row_table['count'];

   $query = "SELECT SUM(amount) as amount FROM payment_methods WHERE payment_method_id = 2 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $gcash=$row_table['amount'];
  

   $query = "select COUNT(id) as count FROM payment_methods WHERE payment_method_id = 2 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $gcash_count=$row_table['count'];


   $query = "SELECT SUM(amount) as amount FROM payment_methods WHERE payment_method_id = 3 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $card=$row_table['amount'];
  

   $query = "select COUNT(id) as count FROM payment_methods WHERE payment_method_id = 3 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $card_count=$row_table['count'];

   $query = "SELECT SUM(amount) as amount FROM payment_methods WHERE payment_method_id = 4  AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $ent=$row_table['amount'];
  

   $query = "select COUNT(id) as count FROM payment_methods WHERE payment_method_id = 4 AND created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND  user_id  = '". $_SESSION['user_id']."'";
   $query_run_table = mysqli_query($conn, $query);
   $row_table = mysqli_fetch_array($query_run_table);
   $ent_count=$row_table['count'];
    
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
    font-size: 20px;
    font-family: 'Times New Roman';
}

/*td,*/
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 20%;
    max-width: 20%;
}

td.quantity,
th.quantity {
    width: 40%;
    max-width: 40%;
    word-break: break-all;
}
  
td.price,
th.price {
    width: 40%;
    max-width: 40%;
    word-break: break-all;
    text-align: right;
    align-content: right;
}

.centered {
    text-align: center;
    align-content: center;
}



.ticket {
    width: 300px; 
    max-width: 300px; 
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
td.description,
th.description {
    width: 20% !important;
    max-width: 20%  !important;
}

td.quantity,
th.quantity {
    width: 30% !important;
    max-width: 30% !important;
    /*word-break: break-all;*/
    text-align: center;
}

td.price,
th.price {
    width: 50% !important;
    max-width: 50% !important;
/* word-break: break-all;*/
    text-align: right;
    align-content: right;
}
            </style>
    </head>
    <body>
    <div class="ticket">
    
            <p class="centered">
            <b>BITS IT Services</b><br><!--
MAHARLIKA HIGHWAY, LOMBOY, TALAVERA, NUEVA ECIJA<br>
TIN NO: 490-693-381-00000-->
    </p>
                
                <?php $now = new \DateTime('now', new DateTimeZone('Asia/Tokyo')); 
                
                $newDate = $now->format('d/m/Y');
                $newTime = $now->format('h:i:sa');
                
                ?>
                <br><b>Date: </b><?php echo $newDate;?>
                <br><b>Time:</b> <?php echo $newTime;?>
                <!--<br><b>Cashier: </b><?php echo $cashier;?>-->
                
            </p>
            <table>
                <thead>
                    <tr>
                        
                        <th colspan="3" style="border-top: 1px solid white;">SUMMARY REPORT</th>
                        
                    </tr>
                </thead>
                <tbody >
                    <tr>
                        <td colspan="3" style="border-top: 1px solid white; font-size: 0.8em;" class="centered"><?php echo $dateTime?></td>
                    </tr>
                    <tr>
                        <td class="description" ><b>Transaction</td>
                        <td class="quantity"><b>Count</b></td>
                        <td class="price" ><b>Amount</b></td> 
                    </tr>
                    <tr  >
                        <td class="description" >Cash</td>
                        <td class="quantity" ><?php echo $cash_count;?></td>
                        <td class="price" >P <?= number_format((float)$cash, 2, ".", ",");  ?></td>
                    </tr>
                    <tr style="border-top: 1px solid white;" >
                        <td class="description" >GCash</td>
                        <td class="quantity" ><?php echo $gcash_count;?></td>
                        <td class="price" >P <?= number_format((float)$gcash, 2, ".", ",");  ?></td>
                    </tr>
                    <tr  style="border-top: 1px solid white;">
                        <td class="description" >Card</td>
                        <td class="quantity" ><?php echo $card_count;?></td>
                        <td class="price" >P <?= number_format((float)$card, 2, ".", ",");  ?></td>
                    </tr>
                    <tr  style="border-top: 1px solid white;">
                        <td class="description" >ENT</td>
                        <td class="quantity" ><?php echo $ent_count;?></td>
                        <td class="price" >P <?= number_format((float)$ent, 2, ".", ",");  ?></td>
                    </tr>
            
                        <tr  style="border-top: 1px solid white;">
                        <td class="description" >VOID</td>
                        <td class="quantity" ><?php echo $void_count;?></td>
                        <td class="price" >(P <?= number_format((float)$void, 2, ".", ",");  ?>)</td>
                    </tr>
                    
                    <tr>
                        <td class="description"><b>TOTAL</b></td>
                        <td class="quantity" ><b><?= $cash_count + $gcash_count + $card_count + $ent_count ?></b></td>
                        <td class="price" ><b>P <?= number_format((float)($cash + $card + $gcash + $ent) - $void, 2, ".", ",");  ?> </b></td>
                    </tr>
                    
                </tbody>
            </table>
            
        </div>
          
    </body>
</html>



<?php } 

//unset($_SESSION['query']);
//unset($_SESSION['datetime']);
?>