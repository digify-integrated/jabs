<?php include 'header.php'; 
$date_post = "";
$dateselected="";
if(isset($_POST) && !empty($_POST['date'])){
    $date_post = $_POST['date'];
    $startDate = $date_post." 09:00:00";
    $dateEnd = strtotime("+1 day", strtotime($date_post));
    $endDate =  date("Y-m-d", $dateEnd) . " 04:00:00";
    $_SESSION['datetime'] = $startDate . " - " . $endDate;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
$dateselected = $startDate . " - " . $endDate;
}
?>

<div class="py-5 bg-dark hero-header mb-5" style="min-height: 100vh;">
           

           
           <!-- Menu Start -->
           <div>
                      <div class="ps-5 pe-5 pt-2" style="background-color: ghostwhite;">
                           <div class="text-center wow"  >
                              <h1 class="section-title ff-secondary text-center text-primary fw-normal">Inventory</h1>
                               <h4 class="mb-1">&nbsp;</h1>
                          </div>
                          <div class="tab-class text-center wow">
                     <form class="form-inline " method="POST" action="">
                <label class="mb-1">Select Date:</label>&nbsp;
            <input id="date" type="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : '' ?>" />&nbsp;
            <button class="btn btn-primary" name="search" id="refresh-btn">Search</button> &nbsp; 
            <button  class="btn btn-primary" onclick="reset_date()">Reset</button>&nbsp; 
            </form>
            <br>
           
<?php  
if(isset($_POST) && !empty($_POST['date'])){ ?>

<div class="row">
                    <div class="col-lg-12">
                        <h4 class="mb-1" style=";text-align:center;"><?php echo $dateselected; ?></h4> 
                    </div>
                </div>
    
<?php
       $query = "select order_details.product_id, order_details.quantity, products.id, products.name, products.category_id from order_details, products WHERE order_details.product_id = products.id AND  order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' GROUP BY order_details.product_id;";
       $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
        
            <div class="row">
                    <div class="col-lg-12">
                         <button target="print_popup" onclick="window.open('inventory_print.php','print_popup','width=1000,height=800');" type="button" class="btn btn-secondary float-end" data-toggle="modal" data-target="#printTable">PRINT INVENTORY SUMMARY</button>
                    </div>
                </div>
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
            $query_count = "select SUM(order_details.quantity) as quantity, orders.status as status from orders, order_details WHERE orders.id = order_details.order_id AND order_details.product_id  = '".$a['id']. "'  AND orders.status=1  AND orders.user_id = '".$_SESSION['user_id']."' AND order_details.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
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


              }
?>

                    </div>
                </div>
        </div>
        </div>
<?php include 'footer.php'; ?>