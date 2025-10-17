<div id="tableDivProductSubCategory"  style="display: none; ">
<!--<div id="tableDivCategory">-->
<?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);

?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} ?>
               
<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addSubCat">Add Product Sub Category</button>
<?php   
$query = "select product_subcategories.id,  product_subcategories.name as subcategory_name, product_categories.name as category_name from product_categories, product_subcategories where product_subcategories.category_id = product_categories.id";
//$query = "select product from  product_subcategories";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="settings_users" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Name</th>    
                    <th>Category</th>    
                    
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){ ?>
                <tr>
                <td><?= $a['subcategory_name']; ?></td>
                <td><?= $a['category_name']; ?></td>
                
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="<?php echo '#editSubCat'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#editSubCat'.$a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteSubCat'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteSubCat'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                      <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteSubCat'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codeSubCat.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete Product SubCategory(<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete Product SubCategory (<?php echo $a['name']; ?>)?  
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
                                                <div class="modal fade" id="<?php echo 'editSubCat'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit Product SubCategory (<?php echo $a['name']; ?>)</h5>
                                                            </div>
                                                            <form action="codeSubCat.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            <div class="modal-body">
                                                            Name: &nbsp; <input  class="form-control" type="text" name="txtName" value="<?= $a['name']; ?>" required><br>
                                                            Category: &nbsp; <select class="form-control select2 form-select" name="txtCategory" required>
                                                                <?php 
                                                                $query = "select id, name from product_categories";
                                                                $query_run = mysqli_query($conn, $query);
                                                                if(mysqli_num_rows($query_run) > 0){
                                                                    foreach($query_run as $a){
                                                                        echo '<option value='. strtoupper($a["id"]).'>'. $a["name"].'</option>';
                                                                    }}else{}
                                                                ?></select><script>$('.select2').select2();</script>
        
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
<div class="modal fade" id="addSubCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Product Category Details</h5>
      </div>
      <form action="codeSubCat.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="id" id="id">
      <table class="center" style="width:100%">
    <tr>
        <td>Name: &nbsp; <input  class="form-control" type="text" name="txtName" required></td>
        <td>Category: &nbsp; <select class="form-control select2 form-select" name="txtCategory" required>
        <?php 
        $query = "select id, name from product_categories";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){
            foreach($query_run as $a){
                echo '<option value='. strtoupper($a["id"]).'>'. $a["name"].'</option>';
            }}else{}
        ?></select><script>$('.select2').select2();</script>
        </td>
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