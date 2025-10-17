<?php 

include 'header.php'; 

?>

<div class="container-xxl py-5 bg-dark mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">CATEGORY</h1>
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
               
<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addTable">Add Category</button>
<?php   $query = "select * from inventory_cat";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="example" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Category</th>
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td><?= $a['name']; ?></td>
               
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="<?php echo '#editTable'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#editTable'.$a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteTable'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteTable'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                                            <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteTable'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codecat.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete Category (<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete Category (<?php echo $a['name']; ?>)?  
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
                                                <!--EDIT MODAL-->
                                                <div class="modal fade" id="<?php echo 'editTable'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit Category (<?php echo $a['name']; ?>)</h5>
                                                            </div>
                                                            <form action="codecat.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">

                                                                    <div class='modal-body profilefont'>Name: &nbsp;
                                                                        <input type="text" name="txtName" value="<?php echo $a['name']; ?>">
                                                                       
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                    <button class='btn btn-dark btn-sm' type='button' data-dismiss='modal'>Cancel</button>
                                                                    <input type="submit" class="btn btn-primary btn-sm" value="Save">
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </form>
                                                </div>
                                                <!--EDIT MODAL-->
                                                
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


<!-- add modal -->
<!-- Modal -->
<div class="modal fade" id="addTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Category Details</h5>
      </div>
      <form action="codecat.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="id" id="id">

<div class='modal-body profilefont'>Name: &nbsp;
    <input type="text" name="txtName" required>
   
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addbtn" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

</div>

















<?php include 'footer.php'; ?>