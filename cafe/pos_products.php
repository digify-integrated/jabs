<?php

require '../api/dbconn.php';

?>

<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
       
       
    </head>
    
      
                        <table id="datatablesSimple">
                                <thead>
                                <tr>
                                    
                                <th>Products</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                                <tbody>
                                <?php 

                                



$query = "select products.id, products.name, product_categories.name as category, products.category_id, products.price from products, product_categories where products.category_id = product_categories.id";
                                    $query_run = mysqli_query($conn, $query);
                                    

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $a)
                                        {
                                            ?>
                                               <tr>
                                                
                                                <td><?= $a['name']; ?></td>
                                                <td><?= $a['category']; ?></td>
                                                <td><?= $a['price']; ?></td>
                                                <td>
                                                
                                               
                                                aaaa<a class="btn btn-primary btn-sm" id="addToCart" href="<?php echo '#addToCart'.$a['id']; ?>" data-toggle="modal" data-target="<?php echo '#addToCart'.$a['id']; ?>">Place Order</a>

                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                </tbody>
                                </table>
                            
                        
               
                <!-- END BODY -->

                <!---STORE MODALS--->
                

             


            
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
