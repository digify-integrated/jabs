<?php 

include 'header.php'; 

?>

<div class="container-xxl py-5 bg-dark mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">ITEMS</h1>
                     <h4 class="mb-1">&nbsp;</h1>
                </div>
                <div class="tab-class text-center wow">
                
               
<?php
/*
STATUS
0-unpaid
1-paid
2-cancel
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
<div id="tableDiv">
<?php if(isset($_SESSION['message'])){
                        $message = $_SESSION['message'];   
                        $status= explode("<>", $message);
                ?>
                <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
                <?php unset($_SESSION['message']);} ?>
            
                

                <br>
                
      <form action="codeItems.php" method="POST">
      <?php 
      $id="";
      $item="";
      $cat_id="";
      $cat_sub_id="";
      $uom_id="";
      
      if(isset($_GET) && isset($_GET['id']) && isset($_GET['id']) != ""){
            $query1 = "select * from inventory_items where  id=" . $_GET['id'];
            $result1 = mysqli_query($conn,$query1);
            $edit = $result1->fetch_assoc();

            $id=$edit['id'];
            $item=$edit['name'];
            $cat_id=$edit['cat_id'];
            $cat_sub_id=$edit['cat_sub_id'];
            $uom_id=$edit['uom_id'];
            //var_dump($edit);
      }?>
      <input type="hidden" name="id" id="id" value="<?=$id?>">
        <table style="width:100%">
            <tr>
            <td>Item: &nbsp; <input type="text" name="txtName" value="<?=$item?>" required>   </td>
            <td> Category: &nbsp; 
            <select class="form-control select2 form-select" name="txtCategory" required>
                <?php 
                $query = "select * from inventory_cat";
                $query_run = mysqli_query($conn, $query);
                if(mysqli_num_rows($query_run) > 0){
                    foreach($query_run as $b){
                        if($cat_id == $b['id']){
                            echo '<option selected value='. $b['id'] .'>'. $b['name'].'</option>';
                        }else{
                            echo '<option value='. $b['id'] .'>'. $b['name'].'</option>';
                        }
                    }
                }?>
                </select><script>$('.select2').select2();</script>
                </td>
                <td> SubCategory: &nbsp; 
            <select class="form-control select2 form-select" name="txtCatSub" required>
                <?php 
                $query = "select * from inventory_cat_sub";
                $query_run = mysqli_query($conn, $query);
                if(mysqli_num_rows($query_run) > 0){
                    foreach($query_run as $b){
                        if($cat_sub_id == $b['id']){
                            echo '<option selected value='. $b['id'] .'>'. $b['name'].'</option>';
                        }else{
                            echo '<option value='. $b['id'] .'>'. $b['name'].'</option>';
                        }
                    }
                }?>
                </select><script>$('.select2').select2();</script>
                </td>
                <td> UOM: &nbsp; 
            <select class="form-control select2 form-select" name="txtuom" required>
                <?php 
                $query = "select * from inventory_uom";
                $query_run = mysqli_query($conn, $query);
                if(mysqli_num_rows($query_run) > 0){
                    foreach($query_run as $b){
                        if($uom_id == $b['id']){
                            echo '<option selected value='. $b['id'] .'>'. $b['name'].'</option>';
                        }else{
                            echo '<option value='. $b['id'] .'>'. $b['name'].'</option>';
                        }
                    }
                }?>
                </select><script>$('.select2').select2();</script>
                </td>
                <td>
                <?php if(isset($_GET) && isset($_GET['id']) && isset($_GET['id']) != ""){?>    
                <button type="submit" name="addbtn" class="btn btn-primary">Update</button>
                <?php }else{?>
                    <button type="submit" name="addbtn" class="btn btn-primary">Save</button>
                    <?php } ?>
            
                </td>
                                </tr>
                                </table> 
      </form>
      <hr>
      <br>


<!--<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addTable">Add Items</button>-->
<?php   $query = "select * from inventory_items";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="settings_products" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Item</th>
                    <th>UOM</th>
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td>
                    <?php 
                $query1 = "select name from inventory_cat where  id=" . $a['cat_id'];
                $result1 = mysqli_query($conn,$query1);
                $cat_name = $result1->fetch_assoc();
                $query2 = "select name from inventory_cat_sub where  id=" . $a['cat_sub_id'];
                $result2 = mysqli_query($conn,$query2);
                $subcat_name = $result2->fetch_assoc();
                echo $cat_name['name'] . " > " . $subcat_name['name'] ;?>
                </td>
                <td><?= $a['name']; ?></td>
                <td>
                <?php
                $query1 = "select name from inventory_uom where  id=" . $a['uom_id'];
                $result1 = mysqli_query($conn,$query1);
                $cat_name = $result1->fetch_assoc();
                echo $cat_name['name'] ;
                ?>
                
                </td>
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="?id=<?php echo $a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteTable'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteTable'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                                            <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteTable'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codeItems.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete Category (<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete Item (<?php echo $a['name']; ?>)?  
                                                            </div>
                                                            <div class='modal-footer'>
                                                            <button class='btn btn-dark btn-sm' type='button' data-dismiss='modal'>Cancel
                                                            </button>
                                                                <input type="submit" class="btn btn-primary btn-sm" value="Delete">
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </form>    
                                                    </div>
                                                <!--DELETE MODAL--->
                                               
                                                
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                </tbody>
                                </table>



</div>















<?php include 'footer.php'; ?>