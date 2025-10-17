<?php
session_start();
 include '../api/dbconn.php'; 
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
    font-size:22px;
    font-family: 'Times New Roman';
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
   /* font-size: 18px;*/
    width: 20%;
    max-width: 20%;
}

td.quantity,
th.quantity {
    /*font-size: 18px;*/
    width: 10%;
    max-width: 10%;
    word-break: break-all;
}

td.price,
th.price {
    /*font-size: 18px;*/
    width: 60%;
    max-width: 60%;
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
</style>
</head>

    <body>
    <div class="ticket">
    <table style="width:100%;">
                <thead>
                    <tr> 
                        <?php if($_GET['p'] == "b"){ ?>
                        <th colspan="3" class="description"  style="border-top: 1px solid white;">***CAFE***</th>
                        <?php }else{ ?>
                        <th colspan="3" class="description"  style="border-top: 1px solid white;">***KITCHEN***</th>
                        <?php }?>
                    </tr>
                    </thead>
                <tbody >
                    <tr style="border-top: 1px  solid black; border-bottom: 1px solid black;">
                        <td class="description" colspan="3"  ><center style="font-size: 24px;"> - - - ORDER SLIP - - - -</center></td>    
                    </tr>
                   
<?php


$table_num = explode("_", $_SESSION['table_id']);
$query_table = "select name from table_category WHERE id = '".$table_num[0]. "'";
$query_run_table = mysqli_query($conn, $query_table);
$row_table = mysqli_fetch_assoc($query_run_table);
//var_dump($query_table);
$dateTime ="";

 $query = "SELECT order_details.note as note, products.shortname, orders.created_at as created_at, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.id = ".$_GET['id'];
 $query_run = mysqli_query($conn, $query);
 //var_dump($query);
 if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $b){ 
        $dateTime = $b['created_at'];
        if($_GET['p']=="b"){
          if($b['product_category'] == "Beverage" || $b['product_category'] == "Cafe" || $b['product_category'] == "Pastry"){
            ?>
              <tr>
              <td style="width: 10%;"><?= $b['quantity']?></td>
              <?php if(!empty($b['note'])){ ?>
              <td style=" width: 40%; text-align:left;"><?= $b['product_name']?></td>
              <td  style=" width: 50%; word-wrap:break-word"><?= $b['note']?></td>
              <?php }else{ ?>
              <td  colspan="2" style=" width: 90% ; text-align:left;"><?= $b['product_name']?></td>
              <?php }?>
             </tr>
            <?php
          }
        }elseif($_GET['p']=="k"){
          if($b['product_category'] != "Beverage" && $b['product_category'] != "Cafe" && $b['product_category'] != "Pastry"){
            //FOOD
            ?>
              <tr>
              <td class="quantity" style=" width: 10%;"><?= $b['quantity']?></td>
              <?php if(!empty($b['note'])){ ?>
              <td style="text-align:left;"><?= $b['product_name']?></td>
              <td  style=" width: 50%; word-wrap:break-word"><?= $b['note']?></td>
              <?php }else{ ?>
                <td  colspan="2" style=" width: 90%; text-align:left;"><?= $b['product_name']?></td>
              <?php }?>
             
              
               </tr>
            <?php
          }
        }
    }
    ?>
                    
                </tbody>
            </table>
            <hr>
            <br><b>Table # </b><?php echo $row_table['name'] ." ". $table_num[1];?> </b>
            <br><b>Date Time: </b><?php echo $dateTime;?>
                
                
        </div>
          
    </body>
</html>

<?php

//header('Location: ticket.php');
}




 ?>

