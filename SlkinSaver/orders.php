<?php 
if(isset($_SESSION['customer'])){
    $customerID = $_SESSION['customer_id'];
    $cartQuery = $dbs->query(@"SELECT * FROM orders WHERE ord_customer=$customerID ORDER BY ord_date DESC;");
    $allOrder = $cartQuery->rowCount();
    $ordersOredered= $dbs->query("SELECT * FROM orders WHERE ord_status='ordered' AND ord_customer=$customerID");
    $ordersDelivered = $dbs->query("SELECT * FROM orders WHERE ord_status='delivered' AND ord_customer=$customerID");
    $ordersCanceled = $dbs->query("SELECT * FROM orders WHERE ord_status='canceled' AND ord_customer=$customerID");
    $ordersOfToday = $dbs->query("SELECT * FROM orders WHERE ord_status='ordered' AND ord_customer=$customerID AND date(ord_date) = current_date");

    if($cartQuery->rowCount()>0){
    ?>
<!-- Cart Start -->
<div class="cart-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <h5 class="bg-white p-2"><i class="fa fa-shipping-fast"></i> My orders</h5> 
                <div class="cart-page-inner">
                    <div class="table-responsive">
                        <table class="table <?php echo isset($_GET['id']) ? ' table-borderless ' : ' table-border ';?>">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order No</th>
                                    <th  style="text-align:left">Shipping Address</th>
                                    <th>status</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody class="align-top">
                            <?php  
                                $cartQuery->execute();
                                while($order = $cartQuery->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr id="order_<?php echo $order['ord_id'];?>">
                                    <td>
                                        <div class="img">                                            
                                            <a href="/?page=orders&id=<?php echo $order['ord_id'];?>#order_<?php echo $order['ord_id'];?>">
                                                <p>#<?php echo $order['ord_id'];?></p>
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align:left">
                                    <?php 
                                        $arrayOfStrings = explode("/",$order['ord_shipping']);
                                        $arrayOfAddress = explode("-",$arrayOfStrings[0]);
                                        echo "name: <small>".$arrayOfAddress[0] ."</small><br>";
                                        echo "phone: <small>".$arrayOfAddress[1]."</small><br>";
                                        echo "email: <small>".$arrayOfAddress[2]."</small><br>";
                                        echo "address: <small>".$arrayOfStrings[1]."</small>";
                                        ?></td>
                                    <td><?php 
                                        if($order['ord_status']=="canceled"){
                                            $status = " badge-danger ";
                                        }else if($order['ord_status']=="ordered"){
                                            $status = " badge-warning ";
                                        }else if($order['ord_status']=="delivered"){
                                            $status = " badge-success ";
                                        }else{
                                            $status = " badge-mute ";
                                        }
                                        echo  "<span class='badge".$status."'>".$order['ord_status']."</span>";
                                            ?></td>
                                    <td><?php echo $order['ord_payment'];?></td>
                                    <td><?php echo "<small>".date("d/m/Y",strtotime($order['ord_date']))." <sup class='badge badge-info'>".date("H:i",strtotime($order['ord_date']))."</sup></small>";?></td>
                                </tr>

                                <?php 
                                    //order details
                                    if(isset($_GET['id']) && $_GET['id']==$order['ord_id']){
                                        $orderID = $_GET['id'];
                                        $orderDetail = $dbs->query(@"SELECT products.*,images.*,order_list.* 
                                                                    FROM order_list 
                                                                        LEFT JOIN products
                                                                            ON products.pro_id = order_list.ord_list_product
                                                                        LEFT JOIN images
                                                                            ON images.img_product_id = order_list.ord_list_product && images.img_default=1 
                                                                    WHERE order_list.ord_list_number=$orderID");  
                                        $orderDetail->execute();                                                                                                      
                                        ?>
                                        <tr style='border-bottom:1px solid silver'>
                                            <td colspan="5" style='text-align:left;'>
                                                <div>
                                                    <h5>#Order details</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th class="text-left">Product</th>
                                                                    <th>Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Total</th>
                                                                
                                                                </tr>
                                                            </thead>
                                                            <tbody class="align-top">
                                                            <?php 
                                                            $total = 0;
                                                            $grandTotal =0;
                                                            $shippingCost =10;
                                                                while($product = $orderDetail->fetch(PDO::FETCH_ASSOC)){
                                                                    $total =   $total+($product['price_sell']*$product['ord_list_qty']);
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="img">                                            
                                                                            <img src="products/<?php echo $product['img_src'];?>" alt="Image">
                                                                            <a href="/?page=product&id=<?php echo $product['pro_id'];?>">
                                                                                <p> <?php echo $product['pro_name'];?></p>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                    <td>$<?php echo $product['price_sell'];?></td>
                                                                    <td>
                                                                        <div class="qtys">
                                                                           <?php echo $product['ord_list_qty'];?>
                                                                        </div>
                                                                    </td>
                                                                    <td>$<?php echo $product['price_sell']*$product['ord_list_qty'];?></td>
                                                                </tr>
                                                            <?php 
                                                                }
                                                                $grandTotal = $total+$shippingCost;
                                                                echo "<tr><td colspan=3 style='text-align:left;'>Shipping price</td><td>$10</td></tr>";
                                                                echo "<tr><td colspan=3 style='text-align:left;'><h2>Total price</h2></td><td><h2>$$grandTotal</h2></td></tr>";
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php    
                                    }
                                }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                     
                </div>             
            </div>
            <div class="col-lg-4">
                <div class="cart-page-inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Order status </h2>
                            <ul class="list-group">
                                <li class="list-group-item active  d-flex justify-content-between align-items-center">
                                    <i class="fa fa-shipping-fast"></i>
                                    <span class="badge badge-primary badge-pill"><?php echo $allOrder;?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Today's orders
                                        <span class="badge badge-primary badge-pill"><?php echo $ordersOfToday->rowCount();?> </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Orders ordered
                                        <span class="badge badge-primary badge-pill"><?php echo $ordersOredered->rowCount();?> </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Orders delivered
                                        <span class="badge badge-primary badge-pill"><?php echo $ordersDelivered->rowCount();?> </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Orders canceled
                                        <span class="badge badge-primary badge-pill"><?php echo $ordersCanceled->rowCount();?> </span>
                                </li>
                            </ul> 
                        </div>
                                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    }else{
        echo "<div class='alert alert-danger m-3'>No order placed</div>";
    }

     }else{
        header("location:/?login=customer");
    }
    ?>
<!-- Cart End -->