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

        
?>

<div class="py-5 bg-dark  mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div>
            <div class="ps-5 pe-5 pt-2" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Sales</h1>
                     <h4 class="mb-1">&nbsp;</h1>
                </div>
                <div class="tab-class text-center wow"  >
                                 
<?php   
$_SESSION['datetime'] = $startDate . " - " . $endDate;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
            ?>  
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <h4 style="text-align:center;"><?php echo $startDate . " - " . $endDate; ?></h5>
                    </div>
                    <div class="col-lg-4">
                        <button target="print_popup" onclick="window.open('daily_report_print.php','print_popup','width=1000,height=800');"  type="button" class="btn btn-secondary float-end" data-toggle="modal" data-target="#printTable">PRINT SUMMARY</button>
                    </div>
                </div>
         
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
                

                </tbody>
                <tfooter>
                    <td><b>TOTAL</b></td>
                    <td><b><?= $cash_count + $gcash_count + $card_count + $ent_count?></b></td>
                    <td><b>P <?= number_format((float)($cash + $card + $gcash + $ent) - $void  , 2, ".", ",");  ?> </b></td>
                </tfooter>
             </table>
        

        
<?php include 'footer.php'; ?>