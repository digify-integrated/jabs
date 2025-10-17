
<div id="tableDivCategory">
<?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);

?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} 
    
      //REMOVE ITEM
      //var_dump($_POST);
   
    ?>
               
    <button type="button" class="btn btn-secondary     float-end" onclick="location.href='./pos.php?t=<?php echo $_SESSION['table_id'];?>';">Add Order</button>
    

        <?php $query = "SELECT orders.created_at, orders.id as order_id FROM orders where orders.status = 0  AND orders.table_id = '".$_SESSION['table_id'] . "' ";
            $query_run = mysqli_query($conn, $query);
            if(mysqli_num_rows($query_run) > 0){ //orders
               
               
               ?>
                <table id="example" class="table table-striped table-bordered" style="width:100%;">
            <thead>
                <tr>
                   <!-- <th style="width:10%;">Order</th>-->
                    <th style="width:50%;">Orders</th>  
                    <th style="width:20%;">Created At</th>    
                    <th style="width:10%;">&nbsp;</th>
                    
                </tr>
            </thead>
                <?php
                foreach($query_run as $a){
            ?>
            <tbody>
              
                
                
                <?php
                //$query = "SELECT products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id      FROM orders, order_details, products where products.id = order_details.product_id AND orders.id = order_details.order_id AND  orders.status = 0  AND orders.id = ".$a['order_id']. " AND orders.table_id = '".$_SESSION['table_id'] . "' ";
                $query = "SELECT order_details.id as product_id, order_details.note as product_note, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.id = ".$a['order_id']. " AND orders.table_id = '".$_SESSION['table_id'] . "'";
                //echo $query;
                $query_run = mysqli_query($conn, $query);
                $count =  mysqli_num_rows($query_run);
                if(mysqli_num_rows($query_run) > 0){?>
                  
                  <tr>
                <td>
                     <table class="table table-bordered" style="width:100%; background-color:white;">
                    <?php foreach($query_run as $b){ 
                        $subtotal = $b['price'] * $b['quantity'];
                        ?>
                       
                         <tr>
                         
                         <td style="width:10%;"><?= $b['quantity']; ?> </td>                                
                        <td style="text-align:left;" style="width:70%;"><?= $b['product_name']; ?></td>
                        <?php if($b['product_note'] != NULL ){?>
                        <td style="text-align:left;" style="width:20%;">Note: <?= $b['product_note']; ?></td>
                        <?php }?> 
                        <td style="width:10%;">
                        <a class="btn btn-danger  " style="background-color:#dc3545;"  id="delete" href="<?php echo '#RemoveItem'.$b['product_id']; ?>" data-toggle="modal" data-target="<?php echo '#RemoveItem'.$b['product_id']; ?>">Remove</a>
                <!--DELETE MODAL-->
                <div class="modal fade" id="<?php echo 'RemoveItem'.$b['product_id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                              <form action="codeCancelItem.php" method="post">
                                  
                                  <div class='modal-dialog' role='document'>
                                  <div class='modal-content'>
                                      <div class='modal-header'>
                                       <h4 class='modal-title' id='exampleModalLabel'>Remove Item (<?php echo $b['product_name']; ?>)</h5>
                                      </div>
                                      <input type="hidden" name="remove_id" id="remove_id" value="<?php echo $b['product_id'];?>">
                                      <input type="hidden" name="remove_order_id" id="remove_order_id" value="<?php echo $a['order_id'];;?>">
                                      <div class='modal-body'>Are you sure you want to Remove Item (<?php echo $b['product_name']; ?>) from Order?  
                                      </div>
                                      <div class='modal-footer'>
                                      <button class='btn btn-dark  ' type='button' data-dismiss='modal'>No
                                      </button>
                                          <input type="submit" class="btn btn-primary  " value="Yes">
                                      </div>
                                  </div>
                                  </div>
                              </form>    
                              </div>
                                                <!--DELETE MODAL--->
                    </td>                           
                    </tr>
                   
                       <?php
                        }
                       }
                       // END PRODUCTS
                ?> </table>
               </td>  
               <td align="right"><?=date_format(date_create($a['created_at']),"F d, Y    H:i A");?></td>
               <td align="right">
            <?php //if($b['product_category'] == "Beverage"){?>
               <a class="btn btn-dark  " style="background-color:black; margin:1px;" onclick="window.open('print.php?id=<?= $a['order_id'];?>&p=b','print_popup','width=1000,height=800');">Cafe</a>
             
               
               <a class="btn btn-dark  " style="background-color:black;  margin:1px;" onclick="window.open('print.php?id=<?= $a['order_id'];?>&p=k','print_popup','width=1000,height=800');">Kitchen</a>
             

               <a class="btn btn-danger  " style="background-color:#dc3545;  margin:1px;"  id="delete" href="<?php echo '#CancelOrder'.$a['order_id']; ?>" data-toggle="modal" data-target="<?php echo '#CancelOrder'.$a['order_id']; ?>">Cancel</a>
                <!--DELETE MODAL-->
                <div class="modal fade" id="<?php echo 'CancelOrder'.$a['order_id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                              <form action="codeCancelOrder.php?del=1" method="post">
                                  
                                  <div class='modal-dialog' role='document'>
                                  <div class='modal-content'>
                                      <div class='modal-header'>
                                       <h4 class='modal-title' id='exampleModalLabel'>Cancel Order(<?php echo $a['order_id']; ?>)</h5>
                                      
                                      </div>
                                      <input type="hidden" name="id" id="id" value="<?php echo $a['order_id'];?>">
                                      
                                      <div class='modal-body'>Are you sure you want to Cancel Order (<?php echo $a['order_id']; ?>)?  
                                      </div>
                                      <div class='modal-footer'>
                                      <button class='btn btn-dark  ' type='button' data-dismiss='modal'>No
                                      </button>
                                          <input type="submit" class="btn btn-primary  " value="Yes">
                                      </div>
                                  </div>
                                  </div>
                              </form>    
                              </div>
                                                <!--DELETE MODAL--->
                </td> 
                     
                
                </tr>
               
                 </tbody><?php 
                 }
                 }?>
                                </table>


</div>
