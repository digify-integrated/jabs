<?php include 'header.php'; 


unset($_SESSION["shopping_cart"]);

if(isset($_POST["add"])){
    
    if(isset($_SESSION["shopping_cart"])){
        $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'id' => $count++,
                'product_idaaa' => $_POST["hidden_id"],
                'product_name' => $_POST["hidden_name"],
                'product_note' => $_POST["note"],
                'product_price' => $_POST["hidden_price"],
                'product_quantity' => $_POST["quantity"],
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
            echo '<script>window.location=""</script>';
      
    }else{
       
        $item_array = array(
            //'id' => 0,
            'id' => 0,
            'product_idaaa' => $_POST["hidden_id"],
            'product_name' => $_POST["hidden_name"],
            'product_note' => $_POST["note"],
            'product_price' => $_POST["hidden_price"],
            'product_quantity' => $_POST["quantity"],
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
    //unset($_POST);
}

if(isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        foreach($_SESSION["shopping_cart"] as $keys => $value){
            if($value["id"] == $_POST["id"]){
                unset($_SESSION["shopping_cart"][$keys]);
                
                echo '<script>window.location=""</script>';
            }
        }
    }
}


//$query = "select * from tables";
//        $query_run = mysqli_query($conn, $query);
        
?>
<!--
 <style>
        .product{
            border: 1px solid #eaeaec;
            margin: 2px 2px 8px 2px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
            min-height: 250px;
        }
        table,th,tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
       
        table th{
            background-color: #efefef;
        }

        .text-info {
            color:  black!important;
        }
    </style>-->
<div class="container-xxl py-5 bg-dark hero-header mb-5" style="min-height: 100vh;">
           
        <!-- Team Start -->
        <div class="container-xxl pt-5 pb-3">
            <div class="container">
             <div class="text-center wow"  >
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal"> Order/s</h5>
                    <!--<h1 class="mb-5">Most Popular Items</h1>-->
                </div>


                <div class="container-xxl py-1 bg-dark hero-header mb-5">
                <div class="container my-0 py-1">
                    <div class="row  g-5">
                        <div class="col-lg-6 text-center text-lg-start" >
                         <div class="text-center wow"  >
                        <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                        </div>
                        <!-- CART -->
<!-- Menu Start -->

                    <div class="tab-class text-center wow"   style="background-color:white;">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <?php 
                    var_dump($_SESSION);
                    $query = "select * from product_categories";
                    $query_run = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $a){ ?>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-<?php echo $a['id'];?>">
                                <i class="fa fa-utensils fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">&nbsp;</small>
                                    <h6 class="mt-n1 mb-0"><?= $a['name']?></h6>
                                </div>
                            </a>
                        </li>
                        <?php } }?>
                    </ul>
                    <div class="tab-content">
                    <?php 
                    if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $a){?>
                            <div id="tab-<?php echo $a['id']?>"  class="tab-pane fade show p-0">
                            <div class="row g-4">
                                
                                <?php 
                                $query_p = "select products.id, products.name, product_categories.name as category, products.category_id, products.price from products, product_categories where products.category_id = product_categories.id AND products.category_id=". $a['id'];

                            $query_run = mysqli_query($conn, $query_p);
                            if(mysqli_num_rows($query_run) > 0){?>
                            <form method="post" action="?action=add">
                                <table  id="" class="display" style="width:100%;     margin: auto; background-color:white;">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Note</th>
                                    <th>&nbsp;</th>
                                    
                                </tr>
                            </thead>
                                <tbody>
            
            <?php foreach($query_run as $a){ 
                ?>
                
                <tr>
                <td><?php echo $a["id"];?> <> <?= $a['name']; ?></td>
                <td>P<?= number_format((float)$a['price'], 2, ".", ","); ?></td>
                <td><input type="number" name="quantity" class="form-control" value="1"></td>
                <td><input type="text" name="note" class="form-control" placeholder="Note"></td>
                <td align="right">
                <input type="text" name="hidden_id" value="<?php echo $a["id"];?>">
                <input type="hidden" name="hidden_name" value="<?php echo $a["name"];?>">
                <input type="hidden" name="hidden_price" value="<?php echo $a["price"];?>">
                <input type="submit" name="add" style="width:100%; margin-top: 2px;" class="btn btn-success" value="Add">
                </td>
                </tr>
                <?php }}//else{ // echo "<h5> No Record Found </h5>"; } ?>
            </form>      
            </tbody>
                </table>
                                
                                
                                
                                
                                
                                
                                
                                <?php /*$result_p = mysqli_query($conn,$query_p);
                                if(mysqli_num_rows($result_p) > 0){
                                    foreach($result_p as $row){
                                    ?>
                                    <div class="col-md-3" style="float: left;">
                                    
                                    <?php
                                    //include 'pos_food_menu.php';
                                    ?><form method="post" action="?action=add&id=<?php echo $row["id"];?>">
                                        <div class="product" >
                                            <!--<img src="img/" width="190px" height="200px" class="img-responsive" style="border-radius: 10px;">-->
                                            <h5 class="text-info"><?php echo $row["name"];?></h5>
                                            <h6 class="text-danger">P <?php echo number_format($row["price"],2);?></h6>
                                            <input type="number" name="quantity" class="form-control" value="1">
                                            <input type="text" name="note" class="form-control" placeholder="Note">
                                            <input type="hidden" name="hidden_name" value="<?php echo $row["name"];?>">
                                            <input type="hidden" name="hidden_price" value="<?php echo $row["price"];?>">
                                            <input type="submit" name="add" style="width:100%; margin-top: 2px;" class="btn btn-success" value="Add">
                                        </div>
                                    </form><?php ?>
                                </div>
                                    
                                    <?php
                                 }}*/
                                  ?>
                            </div>
                        </div>







                        
                        <?php }}?>
                        
                    </div>
                </div>
        <!-- Menu End -->


                        <!-- END CART--->

                       <?php// include 'pos_products.php';?>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                         <div class="text-center wow"  >
                             <h5 class="section-title ff-secondary text-center text-primary fw-normal">Order Details</h5>
                        </div>
                        <?php
                                if(!empty($_SESSION["shopping_cart"])){
                                    $count = 0;
                                    $total=0;?>
                        <table class="table table-bordered" style="background-color:white;">
                                <!--<tr>
                                    
                                    <th width="30%">Product</th>
                                    <th width="10%">Quantity</th>
                                    <th width="13%">Price</th>
                                    <th width="10%">Total Price</th>
                                    <th width="17%">Remove Item</th>
                                </tr>-->
                                <?php
                               /// if(!empty($_SESSION["shopping_cart"])){
                               //     $total=0;
                                    foreach($_SESSION["shopping_cart"] as $key => $value){
                                        $count++;
                                        ?>
                                        <tr>
                                           
                                            <td><?php echo $value["product_idaaa"];?><><?php echo $value["product_name"];?></td>
                                            <td><?php echo $value["product_quantity"];?></td>
                                            <td><?php echo number_format((float)$value["product_quantity"]*$value["product_price"], 2, ".", ",");?></td>
                                            <td><a href="?action=delete&id=<?php echo $value["id"]; ?>"><span class="text-danger">Remove</span></a></td>
                                        </tr>
                                        
                                        <?php
                                        $total = $total + ($value["product_quantity"]*$value["product_price"]);
                                    }
                                    ?>
                                     <tr>
                                        <td colspan="3" align="right">Total</td>
                                        <td align="right"><?php echo number_format((float)$total, 2, ".", ",");;?></td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right"> <button class="btn btn-primary w-100 py-3" type="submit" onclick="location.href='codeCreateOrder.php';">Create Order</button>&nbsp;</td>
                                      
                                    
                                   

                                    </tr>
                                    </table>
                                    
                                   
                                <?php  }?>
                           <!-- </table>-->
                            
                            <!--<iframe src="" width="100%" style="min-height: 100vh;" seamless="seamless" scrollscrolling="no"></iframe>-->
                        </div>
                    </div>
                </div>
            </div>





<?php include 'footer.php';
?>