<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

session_start();
require '../api/dbconn.php';
//var_dump($_SESSION);
if(isset($_SESSION) && $_SESSION['account_id'] != NULL){
  //  var_dump($_SESSION);
 // if(isset($_SESSION['account_id']) && $_SESSION['account_id'] != NULL){   
   // header("Location: tables.php");
 }else{
   header("Location: ../index.php");
 }
//}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BITS IT Services</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<!-- start -->


<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
   <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>-->
   <!-- <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">-->

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../templates/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../templates/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../templates/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../templates/css/style.css" rel="stylesheet">

    <!--end-->
    
        <!--MODAL-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css"/>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
        
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>


<!--MODAL-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<!--CHART-->

        
<!--icon-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--password-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<!--POS PHP-->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<!--<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>-->

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css"/>





<!--SELECT -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>



<script>
    $(document).ready(function(){


      setTimeout(function () {
            // Closing the alert
            $('.alert').alert('close');
        }, 2000);
        

        $("#buttonTable").click(function(){
            $("#tableDiv").slideToggle();
        });
      
        
        new DataTable('#settings_tables', {
            info: false,
            ordering: true,
            paging: true
        });

    
        new DataTable('#settings_products', {
            info: false,
            ordering: true,
            paging: true
        });

        new DataTable('#settings_users', {
            info: false,
            ordering: true,
            paging: true
        });
        new DataTable('#report', {
            info: false,
            ordering: true,
            paging: true
        });

        new DataTable('table.display', {
            info: false,
            ordering: false,
            paging: false
        });

       
});

   
</script>

<script type="text/javascript">



       </script>
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
    </style>



<script>
    $(function() {
        $("#discount, #totalAmount").on("keydown keyup", sumT);
        
            function sumT() {
                let discount = parseFloat($("#discount").val()) || 0;
               // console.log($("#totalAmountHidden").val() +"<>"+$("#discount").val());
            $("#totalAmount").val(parseFloat($("#totalAmountHidden").val().replace(',', '')) - discount);
            //console.log("TOTAL_AMOUNT=>"+ $("#totalAmount").val())
        }
       
        $("#discountBill, #totalAmountBill").on("keydown keyup", sumTBill);
        
        function sumTBill() {
            let discountBill = parseFloat($("#discountBill").val()) || 0;
           // console.log($("#totalAmountHidden").val() +"<>"+$("#discount").val());
        $("#totalAmountBill").val(parseFloat($("#totalAmountHiddenBill").val().replace(',', '')) - discountBill);
        //console.log("TOTAL_AMOUNT=>"+ $("#totalAmount").val())
    }
   


        $("#cash_amount, #gcash_amount , #card_amount , #ent_amount").on("keydown keyup", sumA);
            
            
            function sumA() {
                let cash = parseFloat($("#cash_amount").val())|| 0;
                let gcash = parseFloat($("#gcash_amount").val())|| 0;
                let card = parseFloat($("#card_amount").val())|| 0;
                let ent = parseFloat($("#ent_amount").val())|| 0;
                
                let totalPayment = cash + gcash + card + ent;
                let change = totalPayment - parseFloat($("#totalAmount").val());
                $("#change").val(change);
            //$("#change").val(Number($("#cash_amount").val()) - Number($("#totalAmount").val()));
            if($("#change").val() >= 0){
                //console.log("ddd");
                $("#submit").removeAttr("disabled");
            }
        }



        
    });
//    window.onfocus=function(){
//         location.reload();
//        }
    </script>
 <script>
        function reset_date() {
        $('#date').val('').attr('type', 'text').attr('type', 'date');
        }
        </script>
<script>
function buttonTableCategory() {
  var x = document.getElementById("tableDivCategory");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



function buttonProduct() {
  var x = document.getElementById("tableDivProduct");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


function buttonUser() {
  var x = document.getElementById("tableDivUser");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


function buttonProductCategory() {
  var x = document.getElementById("tableDivProductCategory");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


function buttonProductSubCategory() {
  var x = document.getElementById("tableDivProductSubCategory");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



</script>
</head>

<body >
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
    
        <!--TO DO REMOVE THIS ON LIVE
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>-->
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="../index.php" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>BITS IT Services</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse navbar-nav ms-auto py-1 pe-4" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-1 pe-4">
                    &nbsp;
                        
                    </div>
                <?php 
                
                //if(isset($_SESSION) && isset($_SESSION['usertype'])){?>
                
                    <!--<a href="tables.php" class="btn btn-primary py-2 px-4 bg-dark">Tables</a>&nbsp;-->
                    <!--<a href="sales.php" class="btn btn-primary py-2 px-4 bg-dark">Tickets</a>&nbsp;
                    <a href="salesEOD.php" class="btn btn-primary py-2 px-4 bg-dark">Ticket EOD</a>&nbsp;
                    
                    <a href="sales_transactions.php" class="btn btn-primary py-2 px-4 bg-dark">Transactions</a>&nbsp;-->
                   <!-- <a href="" class="btn btn-primary py-2 px-4 bg-dark">Order</a>&nbsp;
                    <a href="" class="btn btn-primary py-2 px-4 bg-dark">Payments</a>&nbsp;
                    <a href="" class="btn btn-primary py-2 px-4 bg-dark">Menu</a>&nbsp;-->
                    <!--<a href="inventory.php" class="btn btn-primary py-2 px-4 bg-dark">Inventory</a>&nbsp;
                    <a href="daily_report.php" class="btn btn-primary py-2 px-4 bg-dark">Cafe EOD</a>&nbsp;
                    <a href="settings.php" class="btn btn-primary py-2 px-4 bg-dark">Settings</a>&nbsp;-->
                    <a href="inventory.php" class="btn btn-primary py-2 px-4 bg-dark">Bar Inventory</a>&nbsp;
                    <a href="inventory_pos.php" class="btn btn-primary py-2 px-4 bg-dark">POS Inventory</a>&nbsp;
                    <!--<a href="cat.php" class="btn btn-primary py-2 px-4 bg-dark">Category</a>&nbsp;
                    <a href="cat_sub.php" class="btn btn-primary py-2 px-4 bg-dark">SubCategory</a>&nbsp;
                    <a href="uom.php" class="btn btn-primary py-2 px-4 bg-dark">UOM</a>&nbsp;
                    <a href="items.php" class="btn btn-primary py-2 px-4 bg-dark">Items</a>&nbsp;-->
                    <div class="dropdown">
  <button class="btn btn-primary py-2 px-4 dropdown-toggle bg-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Settings
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item btn btn-primary" style="color:black" href="cat.php">Category</a></li>
    <li><a class="dropdown-item btn btn-primary" style="color:black"  href="cat_sub.php">Subcategory</a></li>
    <li><a class="dropdown-item btn btn-primary" style="color:black"  href="uom.php">UOM</a></li>
    <li><a class="dropdown-item btn btn-primary" style="color:black"  href="items.php">Items</a></li>
  </ul>
</div>
                    <a href="codeLogout.php" class="btn btn-primary py-2 px-4 bg-dark">Logout</a>&nbsp;
                
                
                
                </div>
                
            </nav>

        <!-- Navbar & Hero End -->
