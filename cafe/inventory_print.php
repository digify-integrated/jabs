<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
 include '../api/dbconn.php'; 
 //var_dump($_SESSION);
//if(isset($_SESSION) && isset($_SESSION['user_id']) != NULL && isset($_SESSION['query']) != NULL){
 


//$query = $_SESSION['query'];

$dateTime = $_SESSION['datetime'];


$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
//var_dump($query);
//$query_run = mysqli_query($conn, $query);
//    if(mysqli_num_rows($query_run) > 0){
    
    

    
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
    font-size: 18px;
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
            <b>JAB's CAFE</b><br>
MAHARLIKA HIGHWAY, LOMBOY, TALAVERA, NUEVA ECIJA<br>
TIN NO: 490-693-381-00000
    </p>
                
                <?php $now = new \DateTime('now', new DateTimeZone('Asia/Tokyo')); 
                
                $newDate = $now->format('d/m/Y');
                $newTime = $now->format('h:i:sa');
                
                ?>
                <br><b>Date: </b><?php echo $newDate;?>
                <br><b>Time:</b> <?php echo $newTime;?>
                
                
            </p>
            <table>
                <thead>
                    <tr>
                        
                        <th colspan="3" style="border-top: 1px solid white;">INVENTORY REPORT</th>
                        
                    </tr>
                </thead>
                <tbody >
                    <tr>
                        <td colspan="3" style="border-top: 1px solid white; font-size: 0.9em;" class="centered"><?php echo $dateTime?></td>
                    </tr>
</table>
               
                    <?php
                    $total=0;
                    $total_void=0;
                    
//$query = "select products.id, products.name, product_categories.name as category, product_categories.id as category_id, products.shortname, products.description, products.price from products, product_categories where products.category_id = product_categories.id";
       
       $query = "select products.id, products.name, products.shortname, products.description, products.price, products.category_id from products";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table  id="" class="display"  class="table table-striped table-bordered"  style="background-color: white;">
            <thead>
                <tr>
                    <th style="width:10%;">Category</th>   
                    <th style="width:70%;">Product</th>    
                    <th style="width:10%;">Sold</th>    
                    <th style="width:10%;">Void</th>    
                     
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){
                   $subcategory = "";
                   $c = explode('_', $a['category_id']);
                   if(count($c) == 2){
                    $query = "select product_categories.id as category_id, product_categories.name as category, product_subcategories.name as subcategory, product_subcategories.id as subcategory_id from product_categories , product_subcategories where product_subcategories.category_id = product_categories.id and product_categories.id = '". $c[0] . "' and product_subcategories.id = '" .$c[1]. "'";
                $result = mysqli_query($conn,$query);
                $row_name = $result->fetch_assoc();


                //count
                //sold
            $query_count = "select SUM(order_details.quantity) as quantity, orders.status as status from orders, order_details WHERE orders.id = order_details.order_id AND order_details.product_id  = '".$a['id']. "'  AND orders.status=1  AND orders.user_id = '".$_SESSION['user_id']."' AND order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
            $query_run_table = mysqli_query($conn, $query_count);
              $row_count = mysqli_fetch_assoc($query_run_table);
              //void
              $query_void = "select SUM(order_details.quantity) as quantity, orders.status as status from orders, order_details WHERE orders.id = order_details.order_id AND order_details.product_id  = '".$a['id']. "'  AND orders.status=3 AND orders.user_id = '".$_SESSION['user_id']."' AND  order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
              $query_run_table = mysqli_query($conn, $query_void);
              $row_void = mysqli_fetch_assoc($query_run_table);
              if($row_count['quantity'] > 0 || $row_count['quantity'] !=NULL || $row_void['quantity'] > 0 || $row_void['quantity'] !=NULL){
                //end count
                $total = $total +$row_count['quantity'];
                $total_void = $total_void +$row_void['quantity'];
                ?>
                <tr>
                <td style="border-bottom: 1px solid white;"><?=  $row_name['category'] ." > " . $row_name['subcategory'] ?></td>
                <td style="border-bottom: 1px solid white;"><?= $a['name']; ?></td>
                <td style="text-align:right; border-bottom: 1px solid white;" ><?= $row_count['quantity']  ?? 0?> </td>
                <td  style="text-align:right; border-bottom: 1px solid white; color:red;" ><?= $row_void['quantity']  ?? 0?></td>                
                </tr>
            <?php }}}} ?>
                                </tbody>
                                </table>

            <hr>
            <p  style=" font-size: 0.9em;">
            <b>TOTAL SOLD: &nbsp; <?=$total?></b><br>
            <b>TOTAL VOID: &nbsp; <?=$total_void?></b>
          </p>
        </div>
          
    </body>
</html>



<?php //} 
//}

//unset($_SESSION['query']);
//unset($_SESSION['datetime']);
?>