<div id="tableDivProduct"  style="display: none; ">
<!--<div id="tableDivCategory"-->

               
<button type="button" class="btn btn-secondary btn-sm btn-sm float-end" data-toggle="modal" data-target="#addProduct">Add Products</button>
<?php   //$query = "select products.id, products.name, product_categories.name as category, product_categories.id as category_id, products.shortname, products.description, products.price from products, product_categories where products.category_id = product_categories.id";
        $query = "select products.id, products.name, products.shortname, products.description, products.price, products.category_id from products";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table id="settings_products" class="table table-striped table-bordered" style="width:100%; background-color:white;">
            <thead>
                <tr>
                    <th>Category</th>   
                    <th>Name</th>    
                    <th>Short Name</th>    
                    <th>Description</th>    
                    <th>Price</th>    
                     
                    <th style="width:20%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($query_run as $a){
                   // echo $a['category_id'];
                   $subcategory = "";
                   $c = explode('_', $a['category_id']);
                   //var_dump(count($c));
                   if(count($c) == 2){
                   
                    $query = "select product_categories.id as category_id, product_categories.name as category, product_subcategories.name as subcategory, product_subcategories.id as subcategory_id from product_categories , product_subcategories where product_subcategories.category_id = product_categories.id and product_categories.id = '". $c[0] . "' and product_subcategories.id = '" .$c[1]. "'";
                    
                   //}//else{
                    //$query = "select product_categories.id as category_id, product_categories.name as category from product_categories where product_categories.id = '". $a['category_id'] . "'";
                   //}
                //var_dump($a['category_id']);
                //die();
                $result = mysqli_query($conn,$query);
                $row_name = $result->fetch_assoc();
                
                //if(isset($row_name['category']) != NULL && isset($row_name['category']) != "" && isset($row_name['subcategory']) != NULL ){$subcategory = $row_name['category'] ." > " . $row_name['subcategory'];}
                
                ?>
                <tr>
                
                <td><?=  $row_name['category'] ." > " . $row_name['subcategory'] ?></td>
                <td><?= $a['name']; ?></td>
                <td><?= $a['shortname']; ?></td>
                <td><?= $a['description']; ?></td>
                <td><?= $a['price']; ?></td>
                <td align="right">
                <a class="btn btn-success btn-sm" id="edit" href="<?php echo '#editProduct'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#editProduct'.$a['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" id="delete" href="<?php echo '#deleteProduct'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#deleteProduct'.$a['id']; ?>">Delete</a>
                </td>
                </tr>
                      <!--DELETE MODAL-->
                                            <div class="modal fade" id="<?php echo 'deleteProduct'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <form action="codeProducts.php?del=1" method="post">
                                                        
                                                        <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                            <h5 class='modal-title' id='exampleModalLabel'>Delete Product(<?php echo $a['name']; ?>)</h5>
                                                            
                                                            </div>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            
                                                            <div class='modal-body'>Are you sure you want to delete Product (<?php echo $a['name']; ?>)?  
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
                                                <div class="modal fade" id="<?php echo 'editProduct'.$a['id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit Product (<?php echo $a['name']; ?>)</h5>
                                                            </div>
                                                            <form action="codeProducts.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $a['id'];?>">
                                                            <div class="modal-body">
        Name: &nbsp; <input  class="form-control" type="text" name="txtName" value="<?php echo $a['name'];?>" required><br>
        ShortName: &nbsp; <input class="form-control"  type="text" name="txtSName" value="<?php echo $a['shortname'];?>" required><br>
        Category: &nbsp; <select class="form-control select2 form-select" name="txtCategory" required>
        <?php 
        $query = "select product_categories.id as category_id, product_categories.name as category, product_subcategories.name as subcategory, product_subcategories.id as subcategory_id from product_categories left join product_subcategories on product_subcategories.category_id = product_categories.id;";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){
            foreach($query_run as $b){
                $cat = "";
                $v="";
                if($b["subcategory"] != "" || $b["subcategory"] != NULL){$cat = $b["category"]. ' > ' . $b["subcategory"]; 
                 $v=$b["category_id"] . '_' . $b["subcategory_id"] ;
                }
                else{ $cat =  $b["category"];  
                $v = $b["category_id"];
                }
                echo '<option value='. $v .'>'. $cat.'</option>';
            }}else{}
        ?></select>
        <br>
        Price: &nbsp; <input class="form-control"  type="number" name="txtPrice" value="<?= $a['price']; ?>" required><br>
    <div class="input-group">
  <span class="input-group-text">Description</span>
  <textarea name ="txtDescription" class="form-control" aria-label=""><?php echo $a['description'];?></textarea>
</div><br>

                                                            
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
                                        }}
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
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Product</h5>
      </div>
      <form action="codeProducts.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="id" id="id">
<table class="center" style="width:100%">
    <tr>
        <td>Name: &nbsp; <input  class="form-control" type="text" name="txtName" required></td>
        <td>ShortName: &nbsp; <input class="form-control"  type="text" name="txtSName" required></td>
    </tr>
    <tr>
        <td>Category: &nbsp; <select class="form-control select2 form-select" name="txtCategory" required>
        <?php 
        $query = "select product_categories.id as category_id, product_categories.name as category, product_subcategories.name as subcategory, product_subcategories.id as subcategory_id from product_categories left join product_subcategories on product_subcategories.category_id = product_categories.id;";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){
            foreach($query_run as $b){
                $cat = "";
                $v="";
                if($b["subcategory"] != "" || $b["subcategory"] != NULL){$cat = $b["category"]. ' > ' . $b["subcategory"]; 
                 $v=$b["category_id"] . '_' . $b["subcategory_id"] ;
                }
                else{ $cat =  $b["category"];  
                $v = $b["category_id"];
                }
                echo '<option value='. $v .'>'. $cat.'</option>';
            }}else{}
        ?></select>
        </td>
        <td>Price: &nbsp; <input class="form-control"  type="number" name="txtPrice" required></td>
    </tr>
    <tr>
        <td colspan="2"><div class="input-group">
  <span class="input-group-text">Description</span>
  <textarea name ="txtDescription" class="form-control" aria-label=""></textarea>
</div></td>
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