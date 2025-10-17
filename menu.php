
<?php
require './api/dbconn.php';
//$query = "select products.id, products.name, product_categories.name as category, product_categories.id as category_id, products.shortname, products.description, products.price from products, product_categories where products.category_id = product_categories.id";
        $query = "select products.id, products.name, products.shortname, products.description, products.price, products.category_id from products";
        $query_run = mysqli_query($conn, $query);
        if(mysqli_num_rows($query_run) > 0){?>
            <table border="1" id="settings_products" class="table table-striped table-bordered" style="width:50%; background-color:white;">
            <thead>
                <tr>
                    
                    <th style="width:80%;">Name</th>    
                    
                    <th style="width:20%;">Price</th>    
                     
                    
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
                
                
                <td style="width:70%"><?= $a['name']; ?></td>
                
                
                <td><?= $a['price']; ?></td>
                
                </tr>
                      
                                                
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
      

</div>