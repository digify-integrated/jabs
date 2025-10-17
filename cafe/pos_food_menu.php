<!--<div id="tableDivCategory"  style="display: none; ">-->
<div id="tableDivCategory">
<?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);
?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} ?>
               
<!--<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addTableCategory">Add Table Category</button>-->
<?php  $query = "select products.id, products.name, product_categories.name as category, products.category_id, products.price from products, product_categories where products.category_id = product_categories.id";
 //$query = "select * from accounts";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
        
            <table id="example" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Name</th>    
                    <th>Category</th>     
                    <th>Price</th>                
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td><?= $a['name']; ?></td>
                <td><?= $a['category']; ?></td>                                
                <td><?= $a['price']; ?></td>                                
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="<?php echo '#editTableCategory'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#editTableCategory'.$a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteTableCategory'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteTableCategory'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                      <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteTableCategory'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codeTableCategory.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete Table Category(<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete Table Category (<?php echo $a['name']; ?>)?  
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
                                                <div class="modal fade" id="<?php echo 'editTableCategory'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit Table Category (<?php echo $a['name']; ?>)</h5>
                                                            </div>
                                                            <form action="codeTableCategory.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">

                                                                    <div class='modal-body profilefont'>Name: &nbsp;
                                                                        <input type="text" name="txtName" value="<?php echo $a['name']; ?>">
                                                                       
                                                                    </div>

                                                                    <div class='modal-body profilefont'>Table/s: &nbsp;
                                                                        <input type="number" name="txtTable" value="<?php echo $a['table_counts']; ?>">
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


<!---ADD TABLE MODALS--->
<!--<div class="modal fade" id="addTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Add Table </h5></div>
                <form action="codeTables.php" method="POST">
                <div class="modal-body">

                <div class='modal-body profilefont'>Table Name: &nbsp;<input type="text" name="txtName" required></div>
                <div class='modal-body profilefont'>Number of Table: &nbsp;<input type="number" name="txtTable" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" name="addbtn" class="btn btn-primary btn-sm">Save</button>
            </div>
                </form>
        </div>
    </div>
</div>-->
             
<!-- add modal -->
<!-- Modal -->
<div class="modal fade" id="addTableCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Table Category Details</h5>
      </div>
      <form action="codeTableCategory.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="id" id="id">

<div class='modal-body profilefont'>Category Name: &nbsp;
    <input type="text" name="txtName" required>
</div>

<div class='modal-body profilefont'>Table/s: &nbsp;
    <input type="number" name="txtTable" required>
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