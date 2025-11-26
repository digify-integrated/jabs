<?php


session_start();
require '../api/dbconn.php';

if(isset($_SESSION)){
  //if(isset($_SESSION['usertype']) == 'admin' ||isset($_SESSION['usertype']) =='user'){   
    if(isset($_SESSION) && isset($_SESSION['user_id']) != NULL){
    header("Location: tables.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BITS IT Services</title>
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

<body>
     <div class="bg-white p-0 h-100">

        <div class="py-5 bg-dark hero-header min-vh-100 d-flex flex-column">

            <!-- Header -->
            <div class="text-center w-100 mb-0">
                <h1 class="text-primary m-0">
                    <i class="fa fa-diagram-project me-3"></i>BITS IT Services
                </h1>
            </div>

            <!-- Centered Form Wrapper -->
            <div class="container flex-grow-1 d-flex justify-content-center align-items-center">
                <div class="row w-100 justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <form method="POST" action="codeLogin.php">

                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="username" required />
                                <label>User</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" type="password" name="password" required />
                                <label>Password</label>
                            </div>

                            <?php if(isset($_SESSION['message'])){ 
                                $message = $_SESSION['message'];   
                                $status = explode("<>", $message); ?>
                                <div class="alert alert-<?php echo $status[0]; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $status[1]; ?>!
                                </div>
                            <?php unset($_SESSION['message']); } ?>

                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-5 w-100" type="submit">
                                    Login
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../templates/lib/wow/wow.min.js"></script>
        <script src="../templates/lib/easing/easing.min.js"></script>
        <script src="../templates/lib/waypoints/waypoints.min.js"></script>
        <script src="../templates/lib/counterup/counterup.min.js"></script>
        <script src="../templates/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../templates/lib/tempusdominus/js/moment.min.js"></script>
        <script src="../templates/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="../templates/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../templates/js/main.js"></script>
</body>

</html>