<?php 
    require_once("../connect.php");
        //today orders
        $day = date("d",time());
        
        if(isset($_GET['today'])){
            $nbOfResults = $dbs->query("SELECT COUNT(*) FROM orders WHERE DAY(ord_date) = $day")->fetchColumn();
        }else{
            $nbOfResults = $dbs->query("SELECT COUNT(*) FROM orders")->fetchColumn(); }
    if($nbOfResults>0){

        $entitiesPerPage = 10; 
        $nbOfPages = intval($nbOfResults / $entitiesPerPage);

        if( ($entitiesPerPage % $nbOfResults) !== 0 ) {
            $nbOfPages += 1;
        }

        $currentPage = isset($_GET['pg']) ? (int)$_GET['pg'] :0;
        if(!$currentPage) { 
            $currentPage = 1; 
        }
        $pagination = [];

        if ($currentPage !== 1) {
            $pagination[] = [
                'page' => 'Previous',
                'link' => '?page=orders&pg=' . ($currentPage - 1),
                'active' => false,
            ];
        }

        for($i = 0; $i < $nbOfPages; $i++) {
            $pagination[] = [
                'page' => $i,
                'link' => '?page=orders&pg=' . $i,
                'active' => ( $i === $currentPage ),
            ];
        }

        if ($currentPage+1 !== $nbOfPages) {
            $pagination[] = [
                'page' => 'Next',
                'link' => '?page=orders&pg=' . ($currentPage + 1),
                'active' => false,
            ];
        }
        
        $to = (int)(($currentPage-1 ) * $entitiesPerPage);


        if(isset($_GET['today'])){
                $cartQuery = $dbs->query("SELECT * FROM orders  WHERE DAY(ord_date) = $day ORDER BY ord_date DESC LIMIT $entitiesPerPage OFFSET $to;");
            }else{ //all orders
                $cartQuery = $dbs->query("SELECT * FROM orders  ORDER BY ord_date DESC LIMIT $entitiesPerPage OFFSET $to;");
        }

        $allOrder = $dbs->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $ordersOredered = $dbs->query("SELECT * FROM orders WHERE ord_status='ordered'");
        $ordersDelivered = $dbs->query("SELECT * FROM orders WHERE ord_status='delivered'");
        $ordersCanceled = $dbs->query("SELECT * FROM orders WHERE ord_status='canceled'");
        $ordersOfToday = $dbs->query("SELECT * FROM orders WHERE  date(ord_date) = current_date");

        if($cartQuery->rowCount()>0){
            ?>
            <!-- Order Start -->
            <div class="cart-page mt-0">
                <div class="container bg-white  pt-4 pb-4">
                    <div class="row">
                        <div class="col-lg-8">                      
                            <div class="cart-page-inner">
                                <h2>Order List</h2>
                                <div class="table-responsive">
                                    <table class="table <?php echo isset($_GET['id']) ? ' table-borderless ' : ' table-border ';?>">
                                        <thead class="thead-dark">
                                            <tr class="border-bottom border-dark">
                                                <th> No</th>
                                                <th  style="text-align:left;width:100px;">Shipping Address</th>
                                                <th>Order Status</th>
                                                <th>Payment Method</th>
                                                <th>Order Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-top">
                                        <?php  
                                            $cartQuery->execute();
                                            while($order = $cartQuery->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr id="order_<?php echo $order['ord_id'];?>">
                                                <td>
                                                    <span class="btn btn-primary btn-block"><a class="text-white" href="/admin/?page=orders&id=<?php echo $order['ord_id'];?><?php echo isset($_GET['today']) ? "&today=ok" : ""; echo isset($_GET['pg']) ? "&pg=".$currentPage :"";?>#order_<?php echo $order['ord_id'];?>">
                                                        <?php echo $order['ord_id'];?> </a>
                                                    </span>   
                                                </td>
                                                <td style="text-align:left">
                                                <?php 
                                                    $arrayOfStrings = explode("/",$order['ord_shipping']);
                                                    $arrayOfAddress = explode("-",$arrayOfStrings[0]);
                                                    echo "name: <small>".$arrayOfAddress[0]."</small><br>";
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
                                                <td><?php
                                                    if($order['ord_payment']=="FastPay"){
                                                        $image = "../img/fastpay.jpg";
                                                    }else if($order['ord_payment']=="ZainCash"){
                                                        $image = "../img/zaincash.jpg";
                                                    }else{
                                                        $image = "../img/ondelivery.jpg";
                                                    }
                                                        echo "<img class='rounded' src='".$image."' width='40' height='40'><small>".$order['ord_payment'];?></small></td>
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
                                                    <tr class=" <?php echo isset($_GET['id']) ? " shadow-none bg-light":"  ";?>">
                                                        <td colspan="5" style='text-align:left;'>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm">
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
                                                                                    <img src="../products/<?php echo $product['img_src'];?>" alt="Image">
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
                                                                        echo "<tr><td colspan=3 style='text-align:left;'><h2 class='text-primary'>Total price</h2></td><td><h2 class='text-primary'><sup>$</sup>".number_format($grandTotal)."</h2></td></tr>";
                                                                        ?>
                                                                        <tr class="border-top border-mute">
                                                                            <td colspan="4" class="text-left">
                                                                                <a class="btn btn-sm btn-danger <?php echo $order['ord_status']=="canceled" ? " disabled ":" ";?> text-white orderCancel" ord_id="<?php echo $order['ord_id'];?>" >  <i class="fa fa-trash-alt"></i> Cancel Order</a>
                                                                                <a class="btn btn-sm btn-success text-white orderDelivered" ord_id="<?php echo $order['ord_id'];?>"> <i class="fa fa-shipping-fast"></i> Make Delivered </a>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
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
                            <?php
                            if($nbOfResults>$entitiesPerPage){
                                ?>
                            <!-- Pagination Start -->
                            <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                            foreach($pagination as $page){
                                                if($page['page']===$currentPage){
                                                    $cu = " active disabled";
                                                }else{
                                                    $cu = "  ";
                                                }
                                                echo '<li class="page-item '.$cu.'">
                                                        <a class="page-link" href="'.$page['link'].'">'.$page['page'].'</a>
                                                    </li>';
                                            }
                                            ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Pagination Start -->
                            <?php
                        }
                            ?>            
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-page-inner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2> Order status </h2>
                                        <ul class="list-group">
                                            <li class="list-group-item active  d-flex justify-content-between align-items-center">
                                                <i class="fa fa-shipping-fast"></i>
                                                <span class="badge badge-primary badge-pill"><?php echo number_format($allOrder);?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="/admin/?page=orders&today=yes">Today's orders</a>
                                                <span class="badge badge-primary badge-pill"><?php echo number_format($ordersOfToday->rowCount());?> </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Orders ordered
                                                <span class="badge badge-primary badge-pill"><?php echo number_format($ordersOredered->rowCount());?> </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Orders delivered
                                                <span class="badge badge-primary badge-pill"><?php echo number_format($ordersDelivered->rowCount());?> </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Orders canceled
                                                <span class="badge badge-primary badge-pill"><?php echo number_format($ordersCanceled->rowCount());?> </span>
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
         echo "<div class='justify-content-center'>
                <div class='alert alert-danger m-3'> No order placed yet!</div>
               </div>";
    }
    ?>
<!-- Order End -->