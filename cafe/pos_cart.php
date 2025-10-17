<div class="col-lg-6 text-center text-lg-end overflow-hidden">
                         <div class="text-center wow"  >
                              <h1 class="section-title ff-secondary text-center text-primary fw-normal">Order Details</h1>
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
                                           
                                            <td><?php echo $value["product_name"];?></td>
                                            <td><?php echo $value["product_quantity"];?></td>
                                          
                                            <!--<td><?php echo number_format($value["product_price"],2);?></td>-->
                                            <td><?php echo number_format($value["product_quantity"]*$value["product_price"],2);?></td>
                                            <td><a href="?action=delete&id=<?php echo $value["id"]; ?>"><span class="text-danger">Remove</span></a></td>
                                        </tr>
                                        
                                        <?php
                                        $total = $total + ($value["product_quantity"]*$value["product_price"]);
                                    }
                                    ?>
                                     <tr>
                                        <td colspan="3" align="right">Total</td>
                                        <td align="right"><?php echo number_format($total,2);?></td>
                                        
                                    </tr>
                                    
                                    </table>
                                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="location.href='codeCreateOrder.php';">Create Order</button>
                                   
                                <?php  }?>
                           <!-- </table>-->
                            
                            <!--<iframe src="" width="100%" style="min-height: 100vh;" seamless="seamless" scrollscrolling="no"></iframe>-->
                        </div>
                    </div>