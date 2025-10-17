<?php include 'header.php'; 
$date_post = "";
/*if(isset($_POST) && isset($_POST['date'])){
    $date_post = $_POST['date'];
}
$startDate = $date_post." 09:00:00";//$now->toDateString() . " 10:00:00";
$dateEnd = strtotime("+1 day", strtotime($date_post));
$endDate =  date("Y-m-d", $dateEnd) . " 04:00:00";

*/

date_default_timezone_set('Asia/Singapore');
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
}



//$query = "select * from payments";
//$query_run = mysqli_query($conn, $query);
        
?>

<div class="container-xxl py-5 bg-dark  mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Sales</h1>
                     <h4 class="mb-1">&nbsp;</h1>
                </div>
                <div class="tab-class text-center wow"  >

             <!--   <form class="form-inline " method="POST" action="">
                <label class="mb-1" style="text-primary fw-normal">Select Date:</label>&nbsp;
            <input id="date" type="date"   name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : '' ?>" />&nbsp;
            <button class="btn btn-primary  " name="search" id="refresh-btn">Search</button> &nbsp; 
            <button  class="btn btn-primary  " onclick="reset_date()">Reset</button>&nbsp; 
            </form>-->
                                 
<?php   

//if($_POST){
//$query = "select * from payment_methods, users, orders WHERE payment_methods.user_id = users.id AND payment_methods.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND payment_methods.user_id  = '". $_SESSION['user_id'] ."'";
//$query = "select * from payment_methods, users WHERE  payment_methods.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND payment_methods.user_id  = '". $_SESSION['user_id'] ."' AND users.id = '". $_SESSION['user_id'] . "'";


//$query = "select * from payments left join payment_methods ON payments.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
//$query = "select * from payments where payments.created_at BETWEEN '". $startDate . "' AND '" . $endDate . "'";
//$_SESSION['query'] = $query;
$_SESSION['datetime'] = $startDate . " - " . $endDate;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
//echo $query;
      // $query_run = mysqli_query($conn, $query);
       // if(mysqli_num_rows($query_run) > 0){
            
            ?>  
                </div>
         <button target="print_popup" onclick="window.open('daily_report_print.php','print_popup','width=1000,height=800');" style="width:20%;" type="button" class="btn btn-secondary     float-end" data-toggle="modal" data-target="#printTable">PRINT SUMMARY</button>
         <br>
         
          <h4 class="mb-1" style="text-align:center;"><?php echo $startDate . " - " . $endDate; ?></h5>
            <table id="datatablesSimple" class="ui celled table">
            <thead>
                <tr >
                    <th>Transactions</th>
                    <th>Count</th>
                    <th>Amount</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
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

               /* if($a['payment_method_id'] ==1){ 
                    $query_table = "select SUM(`change`) as sukli from payments WHERE payment_reference = '" . $a['payment_reference'] ."'";
                    $query_run_table = mysqli_query($conn, $query_table);
                    $row_table = mysqli_fetch_array($query_run_table);
                    $change = $row_table['sukli'];
                    $cash = $cash + $a['amount'];
                    $cash_count++;
                }
                if($a['payment_method_id'] ==2){ 
                    $gcash = $gcash + $a['amount'];
                    $gcash_count++;
                }
                if($a['payment_method_id'] ==3){
                    $card = $card + $a['amount'];
                    $card_count++;
                }
                if($a['payment_method_id'] ==4){ 
                    $ent = $ent + $a['amount'];
                    $ent_count++;
                }
                */

                
            //}
                ?>
                <tr>
                <td>CASH </td>
                <td><?= $cash_count;?></td>
                <td>P <?= number_format((float)$cash, 2, ".", ",");  ?></td>
                                           
                </tr>
                <tr>
                <td>GCASH </td>
                <td><?= $gcash_count;?></td>
                <td>P <?= number_format((float)$gcash, 2, ".", ",");  ?></td>
                                           
                </tr>
                <tr>
                <td>CARD </td>
                <td><?= $card_count;?></td>
                <td>P <?= number_format((float)$card, 2, ".", ",");  ?></td>
                                           
                </tr>
                <tr>
                <td>ENT </td>
                <td><?= $ent_count;?></td>
                <td>P <?= number_format((float)$ent, 2, ".", ",");  ?></td>                           
                </tr>
               
                <!-- VOID-->
                <tr>
                <td>VOID</td>
                <td><?= $void_count;?></td>
                <td>(P <?= number_format((float)$void, 2, ".", ",");  ?>)</td>                           
                </tr>
                <!--<tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Change(P <?= number_format((float)$change, 2, ".", ",");  ?>)</td>                           
                </tr>-->
                

                </tbody>
                <tfooter>
                    <td><b>TOTAL</b></td>
                    <td><b><?= $cash_count + $gcash_count + $card_count + $ent_count?></b></td>
                    <td><b>P <?= number_format((float)($cash + $card + $gcash + $ent) - $void  , 2, ".", ",");  ?> </b></td>
                </tfooter>
             </table>
             <?php  //}
                //}// }//else{  echo "<h5> No Record Found </h5>"; }?>
          
<?php /*  //$query = "select * from orders WHERE created_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND user_id  = '". $_SESSION['user_id'] ."'";
$query = "select * from  orders WHERE updated_at BETWEEN '". $startDate . "' AND '" . $endDate . "' AND user_id  = '". $_SESSION['user_id'] ."'";
//echo $query;
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
           <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Transactions</h1>
                     <h4 class="mb-1">&nbsp;</h1>
                </div>
         <h4 class="mb-1" style="text-align:center;"><?php echo $startDate . " - " . $endDate; ?></h5>
            <table id="report" class="table table-striped table-bordered" style="width:100%; "  border=1 >
            <thead>
                <tr>
                    <th style="width:20%">Table</th>    
                    
                    <th>Status</th>                
                    <th>Reference</th>                
                    <th>Order Created At</th>                
                    <th>Order Paid At</th>                
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ 
                
                $table_num = explode("_", $a['table_id']);
                $query_table = "select name from table_category WHERE id = '".$table_num[0]. "'";
                $query_run_table = mysqli_query($conn, $query_table);
                $row_table = mysqli_fetch_array($query_run_table);
                $status="";
                if($a['status'] == 1){ $status="Paid";}elseif($a['status'] == 2){$status="<span style='color: red;'>Void/Cancelled</span>";} else{$status="<span style='color: red;'>Unpaid</span>";} 
                $date =  date_format(date_create($a['created_at']),"F d, Y    H:i A");
                if($a['status'] == 1) { $paiddate =  date_format(date_create($a['updated_at']),"F d, Y    H:i A");}
                ?>
                <tr>
                <td><?= $row_table['name'] . ' ' . $table_num[1]?></td>
                <td><?= $status ?></td>                                                            
                <td><?= $a['payment_reference']; ?></td>                                                            
                <td><?= $date; ?></td>    
                <td><?= $paiddate; ?></td>    
                          <?php
                                        }
                                    }
                                    else
                                    {
                                       // echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                </tbody>
                                </table>
            
                
            </div>
        </div>
        <!-- Menu End -->

        </div>
        </div>

                                <?php *///} ?>




        
<?php include 'footer.php'; ?>