<?php include 'header.php'; 

/*var_dump($_POST);
if(isset($_POST["add"])){
    if(isset($_SESSION["shopping_cart"])){
        $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'id' => $count++,
                'product_id' => $_GET["id"],
                'product_name' => $_POST["hidden_name"],
                'product_note' => $_POST["note"],
                'product_price' => $_POST["hidden_price"],
                'product_quantity' => $_POST["quantity"],
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
            //echo '<script>window.location=""</script>';
      
    }else{
       
        $item_array = array(
            //'id' => 0,
            'id' => 0,
            'product_id' => $_GET["id"],
            'product_name' => $_POST["hidden_name"],
            'product_note' => $_POST["note"],
            'product_price' => $_POST["hidden_price"],
            'product_quantity' => $_POST["quantity"],
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if(isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        foreach($_SESSION["shopping_cart"] as $keys => $value){
            if($value["id"] == $_GET["id"]){
                unset($_SESSION["shopping_cart"][$keys]);
                
           //     echo '<script>window.location=""</script>';
            }
        }
    }
}
*/

//$query = "select * from tables";
//        $query_run = mysqli_query($conn, $query);
        
?>
 <style>
      /*  .product{
            border: 1px solid #eaeaec;
            margin: 2px 2px 2px 2px;
            padding: 5px;
            text-align: center;
            background-color: #efefef;
            min-height: 200px;
        }*/
       /* table,th,tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 1%;
        }
       
        table th{
            background-color: #efefef;
        }
        */

        .text-info {
            color:  black!important;
        }
    </style>
<div class="container-xxl py-5 bg-dark  mb-5" style="min-height: 100vh;">
           
        <!-- Team Start -->
        <div class="container-xxl pt-5 pb-3">
            <div class="container">
             <div class="text-center wow"  >
                     <h1 class="section-title ff-secondary text-center text-primary fw-normal"> Order/s</h1>
                    <!--<h1 class="mb-5">Most Popular Items</h1>-->
                </div>


                <div class="container-xxl py-1 bg-white mb-5">
                <div class="container my-0 py-1">
                    <div class="row  g-5">
                        <div class="col-lg-6 text-center text-lg-start" >
                         <div class="text-center wow"  >
                         <h1 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h1>
                        </div>
                        <div class="tab-class text-center wow"   style="background-color:white;">
                            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom">
                                <br>
                            <?php 
                            
                            $query = "select * from product_categories";
                            //$query = "select product_categories.id as category_id, product_categories.name as category, product_subcategories.name as subcategory, product_subcategories.id as subcategory_id from product_categories left join product_subcategories on product_subcategories.category_id = product_categories.id group by category;";
//var_dump($query);
                            $query_run = mysqli_query($conn, $query);
                            if(mysqli_num_rows($query_run) > 0){
                                foreach($query_run as $a){ 
                                    $tab_id = $a['id'];
                                    $tab_name = $a['name'];
                                    ?>
                                <li class="nav-item">
                                    <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-<?php echo $tab_id  ;?>">
                                        <i class="fa fa-utensils fa-2x text-primary"></i>
                                        <div class="ps-3" style="font-size: x-large;">
                                           <!-- <small class="text-body">&nbsp;</small>-->
                                            <h6 class="mt-n1 mb-0"><?= strtoupper($a['name'])?></h6>
                                        </div>
                                    </a>
                                </li>
                                <?php }
                            }?>
                            </ul>
            
       <!--
                            <iframe name="content" style=""></iframe>
<form action="iframe_content.php" method="post" target="content">
<input type="text" name="Name" value="">
<input type="submit" name="Submit" value="Submit">
</form>-->
<!--POS MENU -->

</div><div class="tab-content">
    <?php 
    $query_run = mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run) > 0){
        foreach($query_run as $a){ 
            $tab_id = $a['id'];
            ?>
            <div id="tab-<?php echo $tab_id;?>"  class="tab-pane fade show p-0">
            <?php 
            //tab contents
            $query = "select * from product_subcategories where category_id=" . $tab_id;
            $query_run = mysqli_query($conn, $query);
            if(mysqli_num_rows($query_run) > 0){
                foreach($query_run as $a){ //SUBCATEGORY 
                $cat_id= $a['id'];
                $product_cat_id= $tab_id ."_". $cat_id;
                ?>
                    <div id="cat<?php echo $product_cat_id;?>" class="btn btn-primary px-4 angie" style="font-size: larger;margin-top: 0.5em;" style="margin-top: 0.5em;"><?php echo $a['name']; ?></div> 
                <?php
                }
            }
            ?>
<hr>
<!--SUBCAT-->

<?php

$query = "select * from product_subcategories where category_id=" . $tab_id;
$query_run = mysqli_query($conn, $query);
if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $a){ //SUBCATEGORY 
    $cat_id= $a['id'];
    $product_cat_id= $tab_id ."_". $cat_id;
    
?>
<div style="display:none" class="cat<?=$product_cat_id;?>">
    <?php echo "<h5>" . $a['name'] . "</h5>"; ?>

<!--START MENU-->
<?php 
                $query_p = "select products.id, products.name, product_categories.name as category, products.category_id, products.price from products, product_categories where products.category_id = product_categories.id AND products.category_id='".$product_cat_id ."' ORDER BY products.name ASC";
                //var_dump($query_p);
                $result_p = mysqli_query($conn,$query_p);
                if(mysqli_num_rows($result_p) > 0){?>
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
                <div class="col-md-3" style="float: left;">
                <?php foreach($result_p as $a){ ?>
                    
                        <tr>
                        <form action="iframe_content.php" method="post" target="content">



                       <!-- <form  method="post" action="?action=add&id=<?php echo $a["id"];?>">-->
                        <input type="hidden" name="hidden_id" value="<?php echo $a["id"];?>">
                        <input type="hidden" name="hidden_name" value="<?php echo $a["name"];?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $a["price"];?>">
                        <td><?= $a['name']; ?></td>
                        <td>P<?= number_format((float)$a['price'], 2, ".", ","); ?></td>
                        <td><input type="number" name="quantity" class="form-control" value="1" ></td>   
                        <td><input type="text" name="note" class="form-control" placeholder="Note" ></td>   
                        <td align="right">
                        <!--<button id="add" name="add" class="btn btn-success bi bi-cart" ></button>-->
                        <input type="submit" name="Submit" value="Add" class="btn btn-success bi bi-cart">
                        </form>
                        </td>
                        </tr>   
                    
                <?php
                 }?>
               </table>
                <?php }
                  ?>
<!-- END MENU-->


</div>
<?php
    }}
?>
        </div>
        
        <?php }}?>
        </div>
        </div>


<!--END POS MENU -->

                            <?php // include 'pos_menu.php'; ?>
                            <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                         <div class="text-center wow"  >
                              <h1 class="section-title ff-secondary text-center text-primary fw-normal">Order Details</h1>
                        </div>
                        
                        <iframe  name="content" width="100%"  style="min-height: 100vh;"  style=""></iframe>
                        <!--<iframe src="pos_cart.php" width="100%" style="min-height: 100vh;" seamless="seamless" scrollscrolling="no"></iframe>-->

                       
                            <?php //include 'pos_cart.php';?>
                            </div>
                            </div>
                            
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            </div>
            </div>



            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>
$("div[id^='cat']").click(function() {
  var active = $(this).attr('id');
  $(this).siblings("[class^='cat']:not(." + active + ")").hide(500);
  $(this).siblings("." + active).slideToggle(500);
});
</script>



<?php include 'footer.php';
?>