<?php include 'header.php'; 

?>
             
             <?php
date_default_timezone_set('Asia/Singapore');
$yesterday = date('Y-m-d 09:00:00', strtotime('-1 days')); 
$endyesterday =  date('Y-m-d H:i:s',strtotime('+19 hour',strtotime($yesterday)));
$startDate="";
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
$sdate = date_format(date_create($startDate),"F j, Y g:i a");
$edate  = date_format(date_create($endDate),"F j, Y g:i a");
?>


<div class="container-xxl py-5 bg-dark mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">BAR DAILY INVENTORY</h1>
                     <h4 class="mb-1"><?= $sdate;?> to  <?=$edate?></h1>
                </div>
                <div class="tab-class text-center wow">
                
  
<hr>
              
      <?php 
    
      if(isset($_GET) && isset($_GET['id']) && isset($_GET['id']) != ""){
      
            $query1 = "select * from inventory where  item_id=" . $_GET['id'];
            $result1 = mysqli_query($conn,$query1);
            $edit = $result1->fetch_assoc();
            //var_dump($query1);
      ?>
     
     <form action="codeInventoryBar.php" method="POST">  
        <table width="100%">
            <tr>
            <td>
            <?php 
                $query1 = "select * from inventory_items where  id=" . $_GET['id'];
                $result1 = mysqli_query($conn,$query1);
                $cat_name = $result1->fetch_assoc();
                //var_dump($cat_name);
                $query1 = "select * from inventory_uom where  id=" . $cat_name['uom_id'];
                $result1 = mysqli_query($conn,$query1);
                $uom = $result1->fetch_assoc();
                //var_dump($cat_name);
                ?>
            <input type="hidden" name="item_id" id="item_id" value="<?=$cat_name['id']?>">
            <input type="hidden" name="uom" id="uom" value="<?=$cat_name['uom_id']?>">
            <td>Item:<br><input type="text" name="txtName" value="<?=$cat_name['name']?>" disabled required> </td>
            <td>UOM:<br><input type="text" name="txtName" value="<?=$uom['name']?>" disabled required> </td>
            <!--<td>Beginning: <br> <input type="number" name="txtBeginning" style="width: 100%;" value="<?=( $edit['beginning'] == 0.00) ? '' :  $edit['beginning']?>"></td>-->
            <td>Additional: <br><input type="number" name="txtAdditional" style="width: 100%;" >   </td>
            <td>Out: <br><input type="number" name="txtOut" style="width: 100%;" >   </td>
            <td>Transfer:<br> <input type="number" name="txtTransfer" style="width: 100%;" >   </td>
                
                
                <td><br><button type="submit" name="addbtn" class="btn btn-primary">Save</button></td>
                                </tr>
                                </table> 
      </form>
      <?php } ?>
      <br>
<?php
   //$query = "select * from inventory_items WHERE datetime BETWEEN '". $startDate . "' AND '" . $endDate . "'";
//$query = "select inventory_uom.name as uom, inventory_items.uom_id as uom_id, inventory_items.id as id, inventory_items.name as name from inventory_items, inventory_cat, inventory_uom where  inventory_items.cat_id = inventory_cat.id AND inventory_cat.name = 'BARTENDER' AND inventory_uom.id = inventory_items.uom_id;";


$query = "select inventory_uom.name as uom, inventory_items.uom_id as uom_id, inventory_items.id as id, inventory_items.name as name from inventory_items, inventory_cat, inventory_uom ";

        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="settings_products" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    
                    <th>Item</th>    
                    <th>UOM</th>    
                    <th>Ending<br>(Yesterday)</th>   
                    <th>Beginning<br>(Today)</th>   
                    <th>Additional</th>  
                    <th>Out</th>  
                    <th>Transfer</th>  
                    <th>Actual Count</th>    
                    <th>&nbsp;</th>    
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td><?=$a['name']?></td>
                <td><?=$a['uom']?></td>
               
                <?php 
                $query1 = "SELECT item_id, SUM(beginning) as beginning, SUM(additional) as additional, SUM(b_out) as b_out, SUM(transfer) as transfer from inventory where  item_id=" . $a['id'] . " AND datetime BETWEEN '". $startDate . "' AND '" . $endDate . "'" ;
                
                $result1 = mysqli_query($conn,$query1) or die($mysqli->error);
                $inventory = $result1->fetch_assoc();
                //CURRENT
               ?>  
               
               
                <td>
                    <?php
                    //yesterday
                    $ending=0;
                    // var_dump($query1);
                    if($inventory != NULL){
                    //$query1 = "SELECT SUM(beginning) as beginning, SUM(additional) as additional, SUM(b_out) as b_out, SUM(transfer) as transfer FROM `inventory` where  item_id=" . $inventory['item_id'] . " AND  datetime BETWEEN '". $yesterday . "' AND '" . $endyesterday . "'";
                    $query1 = "SELECT SUM(beginning) as beginning, SUM(additional) as additional, SUM(b_out) as b_out, SUM(transfer) as transfer FROM `inventory` where  item_id=" . $a['id'] . " AND  datetime <= '" .$startDate . "'" ;
                    //var_dump($query1);
                    $result1 = mysqli_query($conn,$query1) or die($mysqli->error);
                    
                    $cat_name = $result1->fetch_assoc();
                    //var_dump($cat_name);
                    $ending= $cat_name['beginning'] + $cat_name['additional'] -   $cat_name['b_out'] -  $cat_name['transfer'];
                    
                     }
                     echo $ending;
                    ?>
                 </td>
                <td><?=$ending;?></td>
                <td><?=( $inventory['additional'] == 0.00) ? '0' :  $inventory['additional']?></td>
                <td><?=( $inventory['b_out'] == 0.00) ? '0' :  $inventory['b_out']?></td>
                <td><?=( $inventory['transfer'] == 0.00) ? '0' :  $inventory['transfer']?></td>
                
                <td><?php 
                $actualcount=0;
                if($inventory != NULL){
                $actualcount= $ending  + $inventory['additional'] - $inventory['b_out'] - $inventory['transfer'];
                echo $actualcount;
                }
                ?>
                </td>
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="?id=<?php echo $a['id']; ?>">Update</a>
                </td>
                </tr>
                
                                                
                                            <?php
                                        }}
                                   // }
                                    else
                                    {
                                       // echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                </tbody>
                                </table>



</div>

















<?php include 'footer.php'; ?>