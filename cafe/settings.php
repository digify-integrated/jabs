<?php include 'header.php'; ?>

<div class="container-xxl py-5 bg-dark mb-5" style="min-height: 100vh;">
                    
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Settings</h1>
                     <h4 class="mb-1">&nbsp;</h1>
                </div>
                <div class="tab-class text-center wow">
      
                    <?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);
?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} ?>
                    <button class="btn btn-primary w-100 py-3" type="submit"  onclick="buttonTableCategory()">Table Management</button>&nbsp;
                    <?php include 'settings_tables.php'?><br>
                    
                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="buttonProduct()">Product Management</button>&nbsp;
                    <?php include 'settings_products.php'?><br>
                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="buttonProductCategory()">Product Category Management</button>&nbsp;
                    <?php include 'settings_productsCat.php'?><br>
                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="buttonProductSubCategory()">Product Sub Category Management</button>&nbsp;
                    <?php include 'settings_productsSubCat.php'?><br>
                   
                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="buttonUser()">User Management</button>&nbsp;
                    <?php include 'settings_users.php'?><br>
                    <!--<h1 class="mb-5">Our Master Chefs</h1>-->
                </div>
               
            </div>
        </div>
        <!-- Team End -->

        </div>
                    </div>
                </div>
            </div>
        </div>
        

        
<?php include 'footer.php'; ?>