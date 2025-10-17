<?php include 'header.php'; 

$query = "select * from tables";
        $query_run = mysqli_query($conn, $query);
        
?>

<div class="container-xxl py-5 bg-dark hero-header mb-5" style="min-height: 100vh;">
           
        <!-- Team Start -->
        <div class="container-xxl pt-5 pb-3">
            <div class="container">
             <div class="text-center wow"  >
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Select Order/s</h5>
                    <!--<h1 class="mb-5">Most Popular Items</h1>-->
                </div>


                <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-0 py-5">
                    <div class="row  g-5">
                        <div class="col-lg-6 text-center text-lg-start" style="background-color:white;">
                         <div class="text-center wow"  >
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu</h5>
                
                </div>
                
                        <?php include 'pos_products.php';?>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <iframe src="test.php" width="100%" style="min-height: 100vh;" seamless="seamless" scrollscrolling="no"></iframe>
                        </div>
                    </div>
                </div>
            </div>





<?php include 'footer.php';
?>