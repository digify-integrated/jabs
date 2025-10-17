<div id="tableDivUser"  style="display: none; ">
<!--<div id="tableDivCategory">-->
<?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);

?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} ?>
               
<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addUser">Add User</button>
<?php   $query = "select * from users";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="settings_users" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Name</th>    
                    <th>Username/Email</th>                
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td><?= $a['name']; ?></td>
                <td><?= $a['email']; ?></td>                                
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="<?php echo '#editUser'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#editUser'.$a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteUser'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteUser'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                      <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteUser'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codeUser.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete User(<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete User (<?php echo $a['name']; ?>)?  
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
                                                <div class="modal fade" id="<?php echo 'editUser'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit User (<?php echo $a['name']; ?>)</h5>
                                                            </div>
                                                            <form action="codeUser.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            <div class="modal-body">
                                                            Name: &nbsp; <input  class="form-control" type="text" name="txtName" value="<?= $a['name']; ?>" required><br>
                                                            Username/Email: &nbsp; <input class="form-control"  type="text" name="txtEmail"  value="<?= $a['email']; ?>" required><br>
                                                            Password: &nbsp; <input class="form-control"  type="password" name="txtPassword"   required>
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
                                       // echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                </tbody>
                                </table>


<!-- add modal -->
<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add User Details</h5>
      </div>
      <form action="codeUser.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="id" id="id">
      <table class="center" style="width:100%">
    <tr>
        <td>Name: &nbsp; <input  class="form-control" type="text" name="txtName" required></td>
        <td>Username/Email: &nbsp; <input class="form-control"  type="text" name="txtEmail" required></td>
    </tr>
    <tr>
        <td colspan="2">Password: &nbsp; <input class="form-control"  type="password" name="txtPassword" required></td>
    </tr>
</table>
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