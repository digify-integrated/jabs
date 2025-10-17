<?php include 'header.php'; 
$date_post = "";
$dateselected="";
if(isset($_POST) && !empty($_POST['date'])){
    $date_post = $_POST['date'];
    $startDate = $date_post." 09:00:00";//$now->toDateString() . " 10:00:00";
    $dateEnd = strtotime("+1 day", strtotime($date_post));
    $endDate =  date("Y-m-d", $dateEnd) . " 04:00:00";


    /*date_default_timezone_set('Asia/Singapore');
    $yesterday = date('Y-m-d 09:00:00', strtotime('-1 days')); 
    $startDate="";
    //$endDate = date('Y-m-d h:i:sa', strtotime(' -1 hours'));
    $endDate =  date('Y-m-d H:i:s');
    $date = date('Y-m-d ')." 00:00:00";
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $midnight = $d->getTimestamp();
    $timeNow= time();
    $diff = abs($midnight - $timeNow)/3600; ///hours
    if($diff >=6){
       $startDate = date('Y-m-d ')." 09:00:00";//$now->toDateString() . " 10:00:00";
       //date today
    }elseif( $diff <=4 ){   
       $startDate = $yesterday;//->toDateString() . " 10:00:00"; 4am
       //get date yesterday
    }else{
       //OFF ito
       $startDate = $endDate;
    }*/
    $_SESSION['datetime'] = $startDate . " - " . $endDate;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
$dateselected = $startDate . " - " . $endDate;
}



//$query = "select * from payments";
//$query_run = mysqli_query($conn, $query);
        
?>

<div class="container-xxl py-5 bg-dark hero-header mb-5" style="min-height: 100vh;">
           

           
           <!-- Menu Start -->
           <div class="container-xxl py-5">
                      <div class="container" style="background-color: ghostwhite;">
                           <div class="text-center wow"  >
                              <h1 class="section-title ff-secondary text-center text-primary fw-normal">Inventory</h1>
                               <h4 class="mb-1">&nbsp;</h1>
                          </div>
                          <div class="tab-class text-center wow">
              

                      <!--CONTENT-->
                     <form class="form-inline " method="POST" action="">
                <label class="mb-1">Select Date:</label>&nbsp;
            <input id="date" type="date"   name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : '' ?>" />&nbsp;
            <button class="btn btn-primary  " name="search" id="refresh-btn">Search</button> &nbsp; 
            <button  class="btn btn-primary  " onclick="reset_date()">Reset</button>&nbsp; 
            </form>
            <br>
           
           
                <!--<a href="../index.php" class="btn btn-primary py-5 px-5"  style="width:30%; margin:5px;font-size: 1.5rem;">HOME</a>&nbsp;
                    <a href="ticket.php" class="btn btn-primary py-5 px-5" style="width:30%;margin:5px;font-size: 1.5rem;">TICKET</a>&nbsp;
                    <a href="buffet.php" class="btn btn-primary py-5 px-5" style="width:30%;margin:5px;font-size: 1.5rem;">BUFFET</a>&nbsp;-->
<?php   
//$query = "select products.id, products.name, product_categories.name as category, product_categories.id as category_id, products.shortname, products.description, products.price from products, product_categories where products.category_id = product_categories.id";
if(isset($_POST) && !empty($_POST['date'])){ ?>
<h4 class="mb-1" style=";text-align:center;"><?php echo $dateselected; ?></h4> 
    
<?php       //$query = "select products.id, products.name, products.shortname, products.description, products.price, products.category_id from products";
       //SELECT orders.status, order_details.product_id, COUNT(*) FROM order_details, orders WHERE orders.id = order_details.order_id AND order_details.created_at BETWEEN '2024-09-18 09:00:00' AND '2024-09-19 04:00:00' GROUP BY order_details.product_id;
       //$query = "SELECT product_id, COUNT(*) FROM order_details  WHERE created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'  GROUP BY product_id";
       //$query = "select * from order_details WHERE order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' ";
       $query = "select order_details.product_id, order_details.quantity, products.id, products.name, products.category_id from order_details, products WHERE order_details.product_id = products.id AND  order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' GROUP BY order_details.product_id;";
    //    /var_dump($query);
       $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
         <button target="print_popup" onclick="window.open('inventory_print.php','print_popup','width=1000,height=800');" style="width:20%;" type="button" class="btn btn-secondary     float-end" data-toggle="modal" data-target="#printTable">PRINT INVENTORY SUMMARY</button>
            <table  id="" class="display"  class="table table-striped table-bordered"  style="background-color: white;">
            <thead>
                <tr>
                    <th style="width:30%;">Category</th>   
                    <th style="width:20%;">Product</th>    
                    <th style="width:20%;">Sold</th>    
                    <th style="width:30%;">Void</th>    
                     
                    
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
            //var_dump($query_count);    
            //echo "<br><br>";
            $query_run_table = mysqli_query($conn, $query_count);
              $row_count = mysqli_fetch_assoc($query_run_table);
              //void
              $query_void = "select SUM(order_details.quantity) as quantity, orders.status as status from orders, order_details WHERE orders.id = order_details.order_id AND order_details.product_id  = '".$a['id']. "'  AND orders.status=3 AND orders.user_id = '".$_SESSION['user_id']."' AND  order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
              //var_dump($query_void);   
              $query_run_table = mysqli_query($conn, $query_void);
              $row_void = mysqli_fetch_assoc($query_run_table);
              if($row_count['quantity'] > 0 || $row_count['quantity'] !=NULL || $row_void['quantity'] > 0 || $row_void['quantity'] !=NULL){
                //end count
                ?>
                <tr>
                <td><?=  $row_name['category'] ." > " . $row_name['subcategory'] ?></td>
                <td><?= $a['name']; ?></td>
                <td><?= $row_count['quantity']  ?? 0 ?> </td>
                <td><?= $row_void['quantity']  ?? 0;?></td>                
                </tr>
            <?php }}}} ?>
                                </tbody>
                                </table>

                  
<?php   

/*
  //var_dump($_POST);
  //$query = "SELECT distinct product_id , orders.status as status FROM orders join order_details on orders.id = order_details.order_id ;";
$query="SELECT order_details.product_id , orders.status as status FROM orders join order_details on orders.id = order_details.order_id group by order_details.product_id;";
$_SESSION['datetime'] = $startDate . " - " . $endDate;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
$_SESSION['query'] = $query;
//  echo $query;
       $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
                
                </div>
            
       
         <?php //if($_POST){ ?> 
          <button target="print_popup" onclick="window.open('inventory_print.php','print_popup','width=1000,height=800');" style="width:20%;" type="button" class="btn btn-secondary     float-end" data-toggle="modal" data-target="#printTable">PRINT INVENTORY SUMMARY</button>
           <h4 class="mb-1" style=";text-align:center;"><?php echo $startDate . " - " . $endDate; ?></h5> <?php }?>
            <table  id="" class="display"  class="table table-striped table-bordered"  style="background-color: white;">
            <thead>
                <tr>
                    <th width = "30%">Name</th>    
                    <th >Sold</th>       
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){
              $query_table = "select name, category_id from products WHERE id = '".$a['product_id']. "' ";
              $query_run_table = mysqli_query($conn, $query_table);
              $row_table = mysqli_fetch_assoc($query_run_table);
              $query_count = "select SUM(quantity) as quantity from order_details WHERE product_id = '".$a['product_id']. "'  AND  order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
              $query_run_table = mysqli_query($conn, $query_count);
              $row_count = mysqli_fetch_assoc($query_run_table);
              if($row_count['quantity'] > 0 && $row_count['quantity'] !=NULL){
              ?>
                <tr>
                <td ><?= $row_table['name']; ?></td>
                <td> <?php if($a['status'] == 1) { echo $row_count['quantity'];}
                elseif($a['status'] == 3){ echo "(".$row_count['quantity'] . ")";}
                else{//echo $row_count['quantity'];
                }  ?>
                
                
                </tr>
                <?php } } 
            //} 
               //{
                // echo "<h5> No Record Found </h5>"; 
               // }
              ?>
                                </tbody>
                                </table>


<?php  //}  */
              }
?>



                      <!--END CONTENT-->  
                    </div>
                </div>













        </div>
        </div>






        
<?php include 'footer.php'; ?>