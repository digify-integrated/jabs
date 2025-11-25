
<div id="tableDivCategory">
<?php if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];   
    $status= explode("<>", $message);

?>
    <div class="alert alert-<?php echo $status[0]?>" role="alert" > <?php echo $status[1];?></div>
    <?php unset($_SESSION['message']);} 
    
      //REMOVE ITEM
      //var_dump($_POST);
   
    ?>
               
    <button type="button" class="btn btn-secondary float-end" onclick="location.href='./pos.php?t=<?php echo $_SESSION['table_id'];?>';">Add Order</button>
    <!-- TIMER DISPLAY -->
   <div id="tableTimerBox" style="margin-top: 60px; margin-bottom: 20px;">
        <h4>Time Left: <span id="rentalTimer">00:00:00</span></h4>

        <input type="number" id="setMinutes" class="form-control" 
            placeholder="Enter minutes" style="width:180px; display:inline-block;" min="1" value="1">

        <button class="btn btn-success" id="startTimerBtn">Start</button>
        <button class="btn btn-danger" id="resetTimerBtn">Reset</button>
    </div>

    <audio id="timerSound" src="alarm.mp3" preload="auto"></audio>

    

        <?php $query = "SELECT orders.created_at, orders.id as order_id FROM orders where orders.status = 0  AND orders.table_id = '".$_SESSION['table_id'] . "' ";
            $query_run = mysqli_query($conn, $query);
            if(mysqli_num_rows($query_run) > 0){ //orders
               
               
               ?>
                <table id="example" class="table table-striped table-bordered" style="width:100%;">
            <thead>
                <tr>
                   <!-- <th style="width:10%;">Order</th>-->
                    <th style="width:50%;">Orders</th>  
                    <th style="width:20%;">Created At</th>    
                    <th style="width:10%;">&nbsp;</th>
                    
                </tr>
            </thead>
                <?php
                foreach($query_run as $a){
            ?>
            <tbody>
              
                
                
                <?php
                //$query = "SELECT products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id      FROM orders, order_details, products where products.id = order_details.product_id AND orders.id = order_details.order_id AND  orders.status = 0  AND orders.id = ".$a['order_id']. " AND orders.table_id = '".$_SESSION['table_id'] . "' ";
                $query = "SELECT order_details.id as product_id, order_details.note as product_note, product_categories.name as product_category, products.name as product_name, order_details.quantity as quantity, products.price as price, orders.id as order_id, order_details.id as order_details_id FROM orders, order_details, products, product_categories where products.id = order_details.product_id AND orders.id = order_details.order_id AND product_categories.id = products.category_id AND orders.status = 0 AND orders.id = ".$a['order_id']. " AND orders.table_id = '".$_SESSION['table_id'] . "'";
                //echo $query;
                $query_run = mysqli_query($conn, $query);
                $count =  mysqli_num_rows($query_run);
                if(mysqli_num_rows($query_run) > 0){?>
                  
                  <tr>
                <td>
                     <table class="table table-bordered" style="width:100%; background-color:white;">
                    <?php foreach($query_run as $b){ 
                        $subtotal = $b['price'] * $b['quantity'];
                        ?>
                       
                         <tr>
                         
                         <td style="width:10%;"><?= $b['quantity']; ?> </td>                                
                        <td style="text-align:left;" style="width:70%;"><?= $b['product_name']; ?></td>
                        <?php if($b['product_note'] != NULL ){?>
                        <td style="text-align:left;" style="width:20%;">Note: <?= $b['product_note']; ?></td>
                        <?php }?> 
                        <td style="width:10%;">
                        <a class="btn btn-danger  " style="background-color:#dc3545;"  id="delete" href="<?php echo '#RemoveItem'.$b['product_id']; ?>" data-toggle="modal" data-target="<?php echo '#RemoveItem'.$b['product_id']; ?>">Remove</a>
                <!--DELETE MODAL-->
                <div class="modal fade" id="<?php echo 'RemoveItem'.$b['product_id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                              <form action="codeCancelItem.php" method="post">
                                  
                                  <div class='modal-dialog' role='document'>
                                  <div class='modal-content'>
                                      <div class='modal-header'>
                                       <h4 class='modal-title' id='exampleModalLabel'>Remove Item (<?php echo $b['product_name']; ?>)</h5>
                                      </div>
                                      <input type="hidden" name="remove_id" id="remove_id" value="<?php echo $b['product_id'];?>">
                                      <input type="hidden" name="remove_order_id" id="remove_order_id" value="<?php echo $a['order_id'];;?>">
                                      <div class='modal-body'>Are you sure you want to Remove Item (<?php echo $b['product_name']; ?>) from Order?  
                                      </div>
                                      <div class='modal-footer'>
                                      <button class='btn btn-dark  ' type='button' data-dismiss='modal'>No
                                      </button>
                                          <input type="submit" class="btn btn-primary  " value="Yes">
                                      </div>
                                  </div>
                                  </div>
                              </form>    
                              </div>
                                                <!--DELETE MODAL--->
                    </td>                           
                    </tr>
                   
                       <?php
                        }
                       }
                       // END PRODUCTS
                ?> </table>
               </td>  
               <td align="right"><?=date_format(date_create($a['created_at']),"F d, Y    H:i A");?></td>
               <td align="right">
            <?php //if($b['product_category'] == "Beverage"){?>
               <a class="btn btn-dark  " style="background-color:black; margin:1px;" onclick="window.open('print.php?id=<?= $a['order_id'];?>&p=b','print_popup','width=1000,height=800');">Cafe</a>
             
               
               <a class="btn btn-dark  " style="background-color:black;  margin:1px;" onclick="window.open('print.php?id=<?= $a['order_id'];?>&p=k','print_popup','width=1000,height=800');">Kitchen</a>
             

               <a class="btn btn-danger  " style="background-color:#dc3545;  margin:1px;"  id="delete" href="<?php echo '#CancelOrder'.$a['order_id']; ?>" data-toggle="modal" data-target="<?php echo '#CancelOrder'.$a['order_id']; ?>">Cancel</a>
                <!--DELETE MODAL-->
                <div class="modal fade" id="<?php echo 'CancelOrder'.$a['order_id']; ?>" tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'> 
                              <form action="codeCancelOrder.php?del=1" method="post">
                                  
                                  <div class='modal-dialog' role='document'>
                                  <div class='modal-content'>
                                      <div class='modal-header'>
                                       <h4 class='modal-title' id='exampleModalLabel'>Cancel Order(<?php echo $a['order_id']; ?>)</h5>
                                      
                                      </div>
                                      <input type="hidden" name="id" id="id" value="<?php echo $a['order_id'];?>">
                                      
                                      <div class='modal-body'>Are you sure you want to Cancel Order (<?php echo $a['order_id']; ?>)?  
                                      </div>
                                      <div class='modal-footer'>
                                      <button class='btn btn-dark  ' type='button' data-dismiss='modal'>No
                                      </button>
                                          <input type="submit" class="btn btn-primary  " value="Yes">
                                      </div>
                                  </div>
                                  </div>
                              </form>    
                              </div>
                                                <!--DELETE MODAL--->
                </td> 
                     
                
                </tr>
               
                 </tbody><?php 
                 }
                 }?>
                                </table>


</div>

<script>
let timerInterval = null;
let remainingSeconds = 0;
let tableId = "<?php echo $_SESSION['table_id']; ?>";

// HTML elements
const startBtn = document.getElementById("startTimerBtn");
const resetBtn = document.getElementById("resetTimerBtn");
const minutesInput = document.getElementById("setMinutes");
const timerDisplay = document.getElementById("rentalTimer");
const timerAudio = document.getElementById("timerSound");

// Compute remaining seconds from end_time
function computeRemainingSeconds(endTime) {
    if (!endTime) return 0;
    const now = new Date().getTime();
    const end = new Date(endTime).getTime();
    return Math.max(0, Math.floor((end - now) / 1000));
}

// Load saved timer from server
function loadTimer() {
    fetch("get_timer.php?table_id=" + tableId)
        .then(res => res.json())
        .then(data => {
            remainingSeconds = computeRemainingSeconds(data.end_time);
            updateTimerDisplay();
            if (remainingSeconds > 0) startTimer(); // auto-start if still active
        })
        .catch(err => console.error("Error loading timer:", err));
}

// Save countdown to server (sets end_time)
function saveTimer(setEndTime = false) {
    let body = "table_id=" + tableId + "&seconds=" + remainingSeconds;
    if (setEndTime) body += "&set_end_time=1";

    fetch("save_timer.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: body
    });
}

// Update visible timer
function updateTimerDisplay() {
    let hrs = String(Math.floor(remainingSeconds / 3600)).padStart(2, '0');
    let mins = String(Math.floor((remainingSeconds % 3600) / 60)).padStart(2, '0');
    let secs = String(remainingSeconds % 60).padStart(2, '0');
    timerDisplay.textContent = `${hrs}:${mins}:${secs}`;
}

// Enable/disable controls based on timer state
function toggleControls(active) {
    startBtn.disabled = active;
    minutesInput.readOnly = active;
}

// Start countdown
function startTimer() {
    if (timerInterval) return;

    toggleControls(true);

    timerInterval = setInterval(() => {
        if (remainingSeconds > 0) {
            remainingSeconds--;
            updateTimerDisplay();
        } else {
            clearInterval(timerInterval);
            timerInterval = null;
            toggleControls(false);
            updateTimerDisplay(); // show Timer Expired
            timerAudio.play();
            alert("⏳ Time is up!");
        }
    }, 1000);
}

// Start button click
startBtn.onclick = function() {
    let inputMin = parseInt(minutesInput.value);
    if (isNaN(inputMin) || inputMin < 1) {
        alert("Please enter a minimum of 1 minute.");
        return;
    }

    // Only start if there is no active timer
    if (remainingSeconds === 0) {
        remainingSeconds = inputMin * 60;
        updateTimerDisplay();
        saveTimer(true); // save and set new end_time
    }

    startTimer();
};

// Reset button
resetBtn.onclick = function() {
    if (!confirm("Reset timer?")) return;

    clearInterval(timerInterval);
    timerInterval = null;
    remainingSeconds = 0;
    updateTimerDisplay();
    toggleControls(false);

    // Delete timer from server
    fetch("save_timer.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `table_id=${tableId}&delete=1` // send a delete flag
    })
    .then(res => res.text())
    .then(data => console.log(data))
    .catch(err => console.error("Error deleting timer:", err));
};


// On page load
window.onload = function() {
    loadTimer();
};
</script>


