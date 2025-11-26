<?php include 'header.php'; 

unset($_SESSION["shopping_cart"]);

$query = "select * from table_category WHERE id = ". explode("_", $_GET["t"])[0];
$query_run = mysqli_query($conn, $query);
$row = mysqli_fetch_row($query_run);

$_SESSION['table_id']  = $_GET['t'];
$query_status = "select * from orders WHERE table_id = '".$_SESSION['table_id'] . "' AND status = 0";
$query_run_status = mysqli_query($conn, $query_status);
$rowCount = mysqli_num_rows($query_run_status);


$table_num = explode("_", $_SESSION['table_id']);
$query_table = "select name from table_category WHERE id = '".$table_num[0]. "'";
$query_run_table = mysqli_query($conn, $query_table);
$row_table = mysqli_fetch_array($query_run_table);

?>

<div class="py-5 bg-dark  mb-5" style="min-height: 100vh;">
    <div>
        <div class="ps-5 pe-5 pt-2" style="background-color: ghostwhite; min-height: 100vh;">
            <div class="text-center wow"  >
                <h1 class="section-title ff-secondary text-center pt-4 text-primary fw-normal"> <?php echo strtoupper($row[1]);?>&nbsp; Table <?php echo explode("_", $_SESSION["table_id"])[1]?></h1>
                <h4 class="mb-1">&nbsp;</h1>
            </div>
            <div class="tab-class text-center wow">
                <div style="background-color: ghostwhite;">
                    <div class="row g-4">
                        <?php if($rowCount > 0){?>
                        <div class="col-lg-4" style="cursor:pointer" data-wow-delay="0.7s" onclick="location.href='#ChangeTable';" class="modal fade"  data-toggle="modal" data-target="#ChangeTable">
                            <div class="service-item rounded pt-2" style="background-color: #FEA116;">
                                <div class="p-3" style="padding: 0.3em !important;">
                                <h5>Change Table</h5>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-lg" id="ChangeTable" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                        <form action="codeChangeTable.php" method="POST"  >                
                            <div class='modal-dialog modal-lg' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h4 class='modal-title' id='exampleModalLabel'>Change Table</h5>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['table_id'];?>">
                                    <div class='modal-body'>
                                        <?php 
                                            $query = "select * from table_category";
                                            $query_run = mysqli_query($conn, $query);
                                        ?>
                                    <div class="tab-class text-center wow">
                                        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                                            <?php if(mysqli_num_rows($query_run) > 0){
                                                foreach($query_run as $a){ ?>
                                                <li class="nav-item">
                                                    <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-<?php echo $a['id'];?>">
                                                        <i class="fa fa-chair fa-2x text-primary"></i>
                                                        <div class="ps-3" style="font-size: x-large;">
                                                            <small class="text-body"><?= $a['table_counts']?> Tables</small>
                                                            <h6 class="mt-n1 mb-0"><?= $a['name']?></h6>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } }?>
                                        </ul>
                                        <div class="tab-content">
                                            <?php if(mysqli_num_rows($query_run) > 0){
                                                foreach($query_run as $a){?>
                                                    <div id="tab-<?php echo $a['id']?>"  class="tab-pane fade show p-0">
                                                        <div class="row g-4" style="--bs-gutter-y: 0.3rem!important;--bs-gutter-x: 0.3rem!important;">
                                                        <?php 
                                                            for ($x = 1; $x <= $a['table_counts']; $x++) {
                                                            $aaa=$a['id']."_".$x;
                                                            if($aaa == $_GET['t']){
                                                                $status = "NA";
                                                            }else{
                                                                $query_status = "select * from orders WHERE table_id = '". $a['id']."_".$x . "' AND status = 0";
                                                                
                                                                $query_run_status = mysqli_query($conn, $query_status);
                                                                $row_status = mysqli_fetch_array($query_run_status);
                                                                    $status ="";
                                                                if($row_status == NULL){
                                                                    $status = "Available";
                                                                    ?>

                                                            <div class="col-lg-3 col-sm-6wow"     onclick="location.href='codeChangetable.php?t=<?php echo $a['id'] .'_' .$x?>';">
                                                                <div class="service-item rounded pt-2" style="background-color: #FEA116;">
                                                                    <div class="p-3" style="padding-bottom: 0.1rem !important;">
                                                                        <h6>Table <?php echo $x; ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                                    else{
                                                                        if($row_status['status'] == 0){
                                                                            $status = ' <h6 class="text-danger">Status: Unpaid</h6>';
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                            
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                    <?php }}?>
                                </div>
                            </div>
                                    </div>
                                    </div>
                                    </div>
                                </form>
                                </div>
                                <div class="col-lg-4" style="cursor:pointer" data-wow-delay="0.7s" onclick="location.href='#PrintBill';" class="modal fade"  data-toggle="modal" data-target="#PrintBill">
                        <div class="service-item rounded pt-2" style="background-color: #FEA116;">
                        <div class="p-3" style="padding: 0.3em !important;">
                                <h5>Print Bill</h5>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="PrintBill" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 

                    <form action="printBill.php" method="POST"  target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');location.reload();">   
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title' id='exampleModalLabel'>Print Bill</h5>
                                </div>
                                <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['table_id'];?>">
                                <div class='modal-body'>
                                    <?php 
                                        $dateTime ="";
                                        $cashier = "";
                                        $total_items=0;
                                        $query = "SELECT orders.user_id, orders.created_at as created_at, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.table_id = '".$_SESSION['table_id'] . "'";
                                        $query_run = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($query_run) > 0){?>
                                            <table style="width:100%; background-color:white;" >
                                            <?php foreach($query_run as $b){ 
                                                $dateTime = $b['created_at'];
                                                $cashier = $b['user_id'];
                                                $subtotal = $b['price'] * $b['quantity'];
                                                $total_items = $total_items + $subtotal;
                                            ?>
                                            <tr>
                                                <td style="width:10%;"><?= $b['quantity']; ?> </td>                                
                                                <td style="text-align:left;" style="width:70%;"><?= $b['product_name']; ?></td>
                                                <td style="width:20%;"><?= number_format((float)$subtotal, 2, ".", ","); ?></td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                    ?>
                                    </table>
                                    <hr>
                                    <table style="width:100%;">
                                        <tr>
                                            <td style="text-align: right; width:70%">SUBTOTAL:</td>
                                            <td style="text-align: right;">P <?= number_format((float)$total_items, 2, ".", ",");?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: right;">SC:</td>
                                            <td style="text-align: right;">P <?= number_format((float)$total_items * 0.10, 2, ".", ",");?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; width:70%"><b>TOTAL:</b></td>
                                            <td style="text-align: right;"><b>P <?= number_format((float)$total_items +(float)$total_items * 0.10 , 2, ".", ",");?></b></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;  color:red;">Less PWD/SC :</td>
                                            <td style="text-align: right; text-align:right">
                                            <input id="discountBill" name="discountBill" type="number"  placeholder="0" step="any">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;  color:red;">Less Ticket/s:</td>
                                            <td style="text-align: right; text-align:right">
                                            <input id="ticketBill" name="ticketBill" type="number"  placeholder="0" step="any">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='modal-footer'>
                                    <button class='btn btn-dark  ' type='button' data-dismiss='modal'>Close</button>
                                    <input type="submit" class="btn btn-primary  " value="Print Bill">
                                </div>
                            </div>
                        </div>
                    </form>    
                </div>
                    <div class="col-lg-4" style="cursor:pointer" data-wow-delay="0.7s" onclick="location.href='#PayOrder';" class="modal fade"  data-toggle="modal" data-target="#PayOrder">
                        <div class="service-item rounded pt-2" style="background-color: #FEA116;">
                            <div class="p-3" style="padding: 0.3em !important;">
                                <h5>Pay Order</h5>
                            </div>
                        </div>
                    </div>  

                     <div class="modal fade" id="PayOrder" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                     <form action="codePayOrder.php" method="POST"  target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');location.reload();">
                                  <div class='modal-dialog' role='document'>
                                  <div class='modal-content'>
                                      <div class='modal-header'>
                                       <h4 class='modal-title' id='exampleModalLabel'>Pay Order</h5>
                                      </div>
                                      <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['table_id'];?>">
                                      <div class='modal-body'>
                                        <?php 
                                        $dateTime ="";
                                        $cashier = "";
                                        $total_items=0;
                                        $query = "SELECT orders.user_id, orders.created_at as created_at, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.table_id = '".$_SESSION['table_id'] . "'";
                                        $query_run = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($query_run) > 0){?>
                                             <table style="width:100%; background-color:white;" >
                                            <?php foreach($query_run as $b){ 
                                               
                                                $dateTime = $b['created_at'];
                                                $cashier = $b['user_id'];
                                                $subtotal = $b['price'] * $b['quantity'];
                                                $total_items = $total_items + $subtotal;
                                                ?>
                                                 <tr>
                                                 <td style="width:10%;"><?= $b['quantity']; ?> </td>                                
                                        <td style="text-align:left;" style="width:70%;"><?= $b['product_name']; ?></td>
                                        <td style="width:20%;"><?= number_format((float)$subtotal, 2, ".", ","); ?></td>                                
                                        
                                        </tr>
                                               <?php
                                                }
                                               }
                                        ?>     
                                    </table>

                                    <hr>
                                    <table style="width:100%;">
                                    <tr>
                                        <td style="text-align: right; width:70%">SUBTOTAL:</td>
                                        <td style="text-align: right;">P <?= number_format((float)$total_items, 2, ".", ",");?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="text-align: right;">SC:</td>
                                        <td style="text-align: right;">P <?= number_format((float)$total_items * 0.10, 2, ".", ",");?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; width:70%"><b>TOTAL:</b></td>
                                        <td style="text-align: right;"><b>P <?= number_format((float)$total_items +(float)$total_items * 0.10 , 2, ".", ",");?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;  color:red;">Less PWD/SC :</td>
                                        <td style="text-align: right; text-align:right">
                                        <input id="discount" name="discount" type="number"  placeholder="0" step="any">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;  color:red;">Less Ticket/s:</td>
                                        <td style="text-align: right; text-align:right">
                                        <input id="ticketdiscount" name="ticketdiscount" type="number"  placeholder="0" step="any">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: right;"><b>AMOUNT DUE:</b></td>
                                        <td style="text-align: right;">
                                        <input name="totalAmount" id="totalAmount" value="<?= $total_items + ($total_items * 0.10);?>" class="text-center form-control-lg mb-2"  style="  width:100%;background-color: gray;border: none;" min="0"  type="text" placeholder="0" readonly/>
                                        
                                        <b><input type="hidden" id="totalAmountHidden" name="totalAmountHidden" value="<?= number_format((float)$total_items,2);?>"/></td>
                                    </tr>
                                    </table>
                                    <hr>
                                    <table style="width:100%;">

                                    <tr>
                                        <td style="text-align: left;vertical-align: top;" colspan="3"><b>Payment Method:</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;">&nbsp;</td>
                                        <td style=" width:70%; text-align: left;vertical-align: top;" colspan="2">
                                        Cash:&nbsp;&nbsp;&nbsp;<input  step="any" type="number" id="cash_amount" name="cash_amount" placeholder="Amount" style="width:75%;">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">&nbsp;</td>
                                        <td style=" width:10%; text-align: left;vertical-align: top;">GCash:</td>                                        
                                        <td style=" width:70%; text-align: left;vertical-align: top;">
                                        <input  step="any" type="number" id="gcash_amount" name="gcash_amount"  placeholder="Amount" style="width:45%;">
                                        <input type="text" id="gcash_reference" name="gcash_reference"  placeholder="Gcash Reference" style="width:45%;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">&nbsp;</td>
                                        <td style=" width:10%; text-align: left;vertical-align: top;">Card:</td>                                        
                                        <td style=" width:70%; text-align: left;vertical-align: top;">
                                        <input  step="any" type="number" id="card_amount" name="card_amount"  placeholder="Amount" style="width:45%;">
                                        <input type="text" id="card_reference" name="card_reference"  placeholder="Card Reference" style="width:45%;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">&nbsp;</td>
                                        <td style=" width:10%; text-align: left;vertical-align: top;">ENT:</td>                                        
                                        <td style=" width:70%; text-align: left;vertical-align: top;">
                                        <input  step="any" type="number" id="ent_amount" name="ent_amount"  placeholder="Amount" style="width:45%;">
                                        <input type="text" id="ent_reference" name="ent_reference"  placeholder="ENT Reference" style="width:45%;"></td>
                                    </tr>
                                    </table>
                                    <hr>
                                    <table style="width:100%;" >
                                    <tr>
                                        <td style="text-align: right;"><b>CHANGE:</b></td>
                                        <td style="text-align: left;"><input name="change" id="change" class="text-center form-control-lg mb-2"  style=" font-size:3rem; width:100%;background-color: gray;border: none;" min="0"  type="text" placeholder="0" readonly/></td>
                                    </tr>
                                    </table>
            
                                        
                                      </div>
                                      <div class='modal-footer'>
                                      <button class='btn btn-dark  ' type='button' data-dismiss='modal'>Cancel
                                      </button>
                                          <input type="submit" class="btn btn-primary  " value="Pay Order">
                                      </div>
                                  </div>
                                  </div>
                              </form>    
                              </div>
                    <?php }?>
                </div>
            </div>
            <br><br>
            <?php include 'table_details_order_list.php';?>
        </div>
<?php include 'footer.php'; ?>