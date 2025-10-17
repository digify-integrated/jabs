<?php


session_start();
require '../api/dbconn.php';

if(isset($_SESSION)){
  //if(isset($_SESSION['usertype']) == 'admin' ||isset($_SESSION['usertype']) =='user'){   
    if(isset($_SESSION) && isset($_SESSION['account_id']) != NULL){
    header("Location: inventory.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Jab's Cafe</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <!--<link href="img/favicon.ico" rel="icon">-->

    <!-- Google Web Fonts -->
    <!--<link rel="preconnect" href="https://fonts.googleapis.com">-->
    <!--<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>-->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Template Stylesheet -->
    <link href="../templates/css/style.css" rel="stylesheet">
   


    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.0.4/js/dataTables.semanticui.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" crossorigin="anonymous"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/2.0.4/css/dataTables.semanticui.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!--MODAL-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>


<script>
    $(document).ready(function(){
        $("#buttonTable").click(function(){
            $("#tableDiv").slideToggle();
        });

});
</script>
<script type="text/javascript">
        setTimeout(function () {
            // Closing the alert
            $('.alert').alert('close');
        }, 2000);
        
       </script>


</head>

<body >
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="../index.php" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Jab's</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse navbar-nav ms-auto py-1 pe-4" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-1 pe-4">
                    &nbsp;
                        
                    </div>
                
                
                </div>
                
            </nav>

        <!-- Navbar & Hero End -->



            <div class="container-xxl py-5 bg-dark hero-header mb-5"  style="min-height: 100vh;">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft"></h1>
                             <?php if(isset($_SESSION['message'])){
                      $message = $_SESSION['message'];   
                      $status= explode("<>", $message);?>
                <div class="alert alert-<?php echo $status[0]?> alert-dismissible fade show" role="alert">
                <?php echo $status[1];?>!
                             </div>
                <?php 
            unset($_SESSION['message']);
                } ?>
                 <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <h1 class="section-title ff-secondary text-center text-primary fw-normal">Inventory</h1>
                </div>
                            <p> <form method="POST" action="codeLogin.php">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" type="text" name="username" required />
                                                    <label for="inputUsername">User</label>
                                                </div>
                                                <div class="form-floating mb-3">

                                                    <input class="form-control" type="password" name="password" required id="myInput" value="" />
                                                    <label for="inputPassword" type="hidden">Password</label>
                                                    
                                                </div>
                                                <div>  
                                                <button class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft"  type="submit">Login</button>
                                                </div>
                                            </form> </p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navbar & Hero End -->

        <?php include 'footer.php'; ?>