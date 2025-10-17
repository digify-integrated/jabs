<?php include 'header.php'; 

$query = "select * from table_category";
$query_run = mysqli_query($conn, $query);
        
?>


<!--SELECT -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<div class="container-xxl py-5 bg-dark  mb-5" style="min-height: 100vh;">
           
 <!-- Menu Start -->
 <div class="container-xxl py-5">
            <div class="container" style="background-color: ghostwhite;">
                 <div class="text-center wow"  >
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Select Table</h1>
                     <h4class="mb-1">&nbsp; </h5> 
               

                
                </div>
                
                <div class="tab-class text-center wow"  >
                

                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom">
                    <?php if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $a){ ?>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-<?php echo $a['id'];?>" onclick="document.getElementById('tablesSearch').src='tables2.php?id=<?php echo $a['id'];?>'; return false;">
                                <i class="fa fa-chair fa-2x text-primary"></i>
                                <div class="ps-3" style="font-size: x-large;">
                                    <small class="text-body"><?= $a['table_counts']?> Tables</small>
                                    <h6 class="mt-n1 mb-0"><?= $a['name']?></h6>
                                </div>
                            </a>
                        </li>
                        <?php } }?>
                    </ul>
                    <div class="tab-content">
                       




<!--
<form action="tables2.php" method="post" target="content">
<input type="text" name="Name" value="">
<input type="submit" name="Submit" value="Submit">
</form>-->



                   <iframe id="tablesSearch" name="content"  src="" width="100%" style="min-height: 100vh;" seamless="seamless" scrollscrolling="no"></iframe>
                    <br>
                    <?php // }?>
                </div>
            </div>
        </div>
        <!-- Menu End -->

        </div>
        </div>






        
<?php include 'footer.php'; ?>