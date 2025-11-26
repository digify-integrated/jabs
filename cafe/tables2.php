<?php
 //   ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

session_start();
require '../api/dbconn.php';
//var_dump($_SESSION);
//if(isset($_SESSION) && $_SESSION['user_id'] != NULL){
  //  var_dump($_SESSION);
 // if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != NULL){   
   // header("Location: tables.php");
// }else{
//   header("Location: ../index.php");
// }
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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

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
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>-->



    </head>
<body style="background-color: ghostwhite;">
        <?php //include 'header.php'; 

//session_start();

//$Submit = isset($_POST['Submit']) ? $_POST['Submit'] : false;
//$Name = isset($_POST['Name']) ? $_POST['Name'] : '';



//var_dump($_POST);
$query = "select * from table_category where id = " .$_GET['id'];
$query_run = mysqli_query($conn, $query);
        
?>


<!--SELECT -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<br>
<div class="tab-content">
<form class="form-inline text-end " method="POST" action="" >
                        <select class="form-control select2 form-select" name="q"  style="width:25%;" onchange="this.form.submit()">
                                    <option disabled selected>Search Table</option>
                                    
                                      <?php if(mysqli_num_rows($query_run) > 0){
                                        foreach($query_run as $a){ 
                                     for ($x = 1; $x <= $a['table_counts']; $x++) {
                                        echo "<option value='". $a['id']."_".$x . "'>" . $a['name'] .  " " .$x."</option> ";
                                        
                                     } } } ?>
                                </select>
                                <script>
                                $('.select2').select2();
                                </script>
                        <!--<button class="btn btn-primary  " name="search" id="refresh-btn"><span class="glyphicon glyphicon-search">Search</span></button> -->&nbsp; 
                        
                        </form>    
                        <br>
                    <?php
                   // var_dump($_POST["q"]); 
                    if(isset($_POST["q"])){?>


                            <div id="tabSearch"  class="tab-pane fade show p-0 active">
                            <div class="row g-4 w-100" style="--bs-gutter-y: 0.3rem!important;--bs-gutter-x: 0.3rem!important;">
                                <?php 
                                //for ($x = 1; $x <= $a['table_counts']; $x++) {
                                    //check if available or not
                                    $query_status = "select * from orders WHERE table_id = '". $_POST['q']. "' AND status = 0";
                                    $query_run_status = mysqli_query($conn, $query_status);
                                    $row_status = mysqli_fetch_array($query_run_status);
                                        $status ="";
                                    if($row_status == NULL){ //walang order
                                        $status = ' <p class="text-success">Available</p>';
                                    }else{
                                        if($row_status['status'] == 0){ //unpaid
                                            $status = ' <p class="text-danger">Unpaid</p>';
                                        }
                                    }
                                    ?>

<div class="col-lg-3" style="cursor:pointer" onclick="parent.document.location.href ='./table_details.php?t=<?php echo $_POST['q']?>';">
                                        <div class="service-item rounded pt-2" style="background-color: #FEA116;">
                                    <div class="p-3">
                                        <?php 
                                        $tc = explode('_', $_POST['q']);
                                        $query_tName = "select * from table_category WHERE id = " . $tc[0];
                                        $query_run_tName = mysqli_query($conn, $query);
                                        $row_tName = mysqli_fetch_array($query_run_tName);
                                        ?>
                                        <h5><?php echo $row_tName['name']; ?></h5>   
                                        <h4><?php echo  "Table " .  $tc[1]; ?></h4>
                                        <h5><?php echo $status;?></h5>
                                        <h5 style="color:#000;"><b>Remaining Time: <br/><span id="timer-<?php echo $tc[1].'_'.$x; ?>" class="text-danger">--:--:--</span></b></h5>
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                  //}
                                  ?>
                            </div>
                        </div>
                    



                <?php }else{ ?>
                    <?php if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $a){?>
                            <!--<div id="tab-<?php echo $a['id']?>"  class="tab-pane fade show p-0">-->
                            <div class="row g-4 w-100" style="--bs-gutter-y: 0.3rem!important;--bs-gutter-x: 0.3rem!important;">
                                <?php 
                                for ($x = 1; $x <= $a['table_counts']; $x++) {
                                    //check if available or not
                                    $query_status = "select * from orders WHERE table_id = '". $a['id']."_".$x . "' AND status = 0";
                                    
                                    $query_run_status = mysqli_query($conn, $query_status);
                                    $row_status = mysqli_fetch_array($query_run_status);
                                        $status ="";
                                    if($row_status == NULL){ //walang order
                                        $status = ' <p class="text-success">Available</p>';
                                    }else{
                                        if($row_status['status'] == 0){ //unpaid
                                        $status = ' <p class="text-danger">Unpaid</p>';

                                       
                                        }
                                    }
                                    ?>
                        <div class="col-lg-3" style="cursor:pointer" onclick="parent.document.location.href ='./table_details.php?t=<?php echo $a['id'] .'_' .$x?>';">
                                    <div class="service-item rounded" style="background-color: #FEA116;">
                                    <div class="p-3" style="padding-bottom: 0.3rem !important; text-align:center;">
                                        <h4>TABLE &nbsp; <?php echo $x; ?></h4>
                                        <h5><?php echo $status;?></h5>
                                        <h5 style="color:#000;"><b>Remaining Time: <br/> <span id="timer-<?php echo $a['id'].'_'.$x; ?>" class="text-danger">--:--:--</span></b></h5>
                                        
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                  } }
                                  ?>
                            </div>
                        </div>
                    <?php  }}?>    
                </div>
            </div>
        </div>
        <!-- Menu End -->

        </div>
        </div>


  <audio id="timerSound" src="alarm.mp3" preload="auto"></audio>


<script>
let tableTimers = {};      // { "3_1": {seconds, table_name, table_number}, ... }
let tableIntervals = {};   // store intervals to prevent duplicates
const timerAudio = document.getElementById("timerSound");

// Format seconds into HH:MM:SS or "Timer Expired"
function formatTime(seconds) {
    if (seconds <= 0) return "Timer Expired";
    const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
    const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
    const secs = String(seconds % 60).padStart(2, '0');
    return `${hrs}:${mins}:${secs}`;
}

// Update individual timer display
function updateTimerDisplay(tableId) {
    const el = document.getElementById("timer-" + tableId);
    if (!el || !tableTimers[tableId]) return;

    el.textContent = formatTime(tableTimers[tableId].seconds);
}

// Start countdown for a single table
function startTimerForTable(tableId) {
    if (tableIntervals[tableId] || tableTimers[tableId].seconds <= 0) return;

    tableIntervals[tableId] = setInterval(() => {
        const table = tableTimers[tableId];
        if (!table) return;

        if (table.seconds > 0) {
            table.seconds--;
            updateTimerDisplay(tableId);

            // Optional: save remaining seconds to server
            fetch("save_timer.php", {
                method: "POST",
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: `table_id=${tableId}&seconds=${table.seconds}`
            }).catch(err => console.error("Error saving timer:", err));
        } else {
            updateTimerDisplay(tableId);
            clearInterval(tableIntervals[tableId]);
            tableIntervals[tableId] = null;
            
            timerAudio.play();
            alert(`⏳ Timer expired for ${table.table_name} Table ${table.table_number}`);
        }
    }, 1000);
}

// Start all timers
function startAllTimers() {
    for (const tableId in tableTimers) {
        updateTimerDisplay(tableId);
        if (tableTimers[tableId].seconds > 0) {
            startTimerForTable(tableId);
        }
    }
}

// Load timers from server
function loadAllTimers() {
    fetch("get_all_timers.php")
        .then(res => res.json())
        .then(data => {
            // Transform seconds dynamically based on end_time
            for (const tableId in data) {
                const table = data[tableId];
                table.seconds = Math.max(0, parseInt(table.seconds));

                // Check for expired timers
                if (table.seconds <= 0) {
                    // Try to play audio (may fail if no user interaction yet)
                    timerAudio.play().catch(err => console.log("Audio blocked:", err));

                    // Show alert
                    alert(`⏳ Timer expired for ${table.table_name} Table ${table.table_number}`);
                }
            }

            tableTimers = data;
            startAllTimers();
        })
        .catch(err => console.error("Error loading timers:", err));
}

// Run on page load
window.onload = loadAllTimers;
</script>



        
<?php // include 'footer.php'; ?>