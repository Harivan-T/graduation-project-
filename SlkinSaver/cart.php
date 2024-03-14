<?php 
if(isset($_SESSION['customer'])){

        $customerID = $_SESSION['customer_id'];
        $cartQuery = $dbs->query(@"SELECT products.*,images.*,carts.* 
                                    FROM carts 
                                        LEFT JOIN products
                                            ON products.pro_id = carts.proID
                                        LEFT JOIN images
                                            ON images.img_product_id = carts.proID && images.img_default=1 
                                    WHERE carts.custID=$customerID  ORDER BY cartAdded DESC;");
        $cartQuery->execute();
        if($cartQuery->rowCount()>0){
        ?>
    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <h5 class="bg-white p-2"><i class="fa fa-shopping-bag"></i> Cart</h5>
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody class="align-top">
                                <?php 
                                $total = 0;
                                $grandTotal =0;
                                $shippingCost =10;
                                    while($product = $cartQuery->fetch(PDO::FETCH_ASSOC)){
                                        $total =   $total+($product['price_sell']*$product['proQty']);
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
                                            <div class="qty" id="<?php echo $product['cartID'];?>">
                                                <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                                    <input type="text" disabled value="<?php echo $product['proQty'];?>">
                                                <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td>$<?php echo $product['price_sell']*$product['proQty'];?></td>
                                        <td><button class="deleteProduct" action="cart" id="<?php echo $product['cartID'];?>"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                <?php 
                                    }
                                    $grandTotal = $total+$shippingCost;
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
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h2>Cart Summary</h2>
                                        <p>Sub Total<span>$<?php echo  $total;?></span></p>
                                        <p>Shipping Cost<span>$<?php echo $shippingCost;?></span></p>
                                        <h2>Grand Total<span>$<?php echo $grandTotal;?></span></h2>
                                    </div>
                                    <div class="shipping-address mt-4">
                                        <h2>Shipping Address</h2>
                                        <div class="row cart-content">
                                            <div class="col-lg-12">
                                                <label>Full Name</label>
                                                <input class="form-control" type="text" id="full_name" placeholder="Full Name" require>
                                            </div> 
                                            <div class="col-lg-6">
                                                <label>E-mail</label>
                                                <input class="form-control" type="text" id="email" placeholder="E-mail" require>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Mobile No</label>
                                                <input class="form-control" type="text" id="phone" placeholder="Mobile No" require>
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Address</label>
                                                <input class="form-control" type="text" id="address" placeholder="Address" require>
                                            </div>
                                            
                                        </div>
                                    </div> 
                                    <div class="checkout mt-3">
                                        <div class="payment-methods">
                                            <h2>Payment Methods</h2>
                                            <div class="payment-method">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="payment-1" name="payment">
                                                    <label class="custom-control-label" for="payment-1">ZainCash</label>
                                                </div>
                                                <div class="payment-content" id="payment-1-show">
                                                    <p>
                                                        Pay with ZainCash wallet.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="payment-method">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="payment-2" name="payment">
                                                    <label class="custom-control-label" for="payment-2">FastPay</label>
                                                </div>
                                                <div class="payment-content" id="payment-2-show">
                                                    <p>
                                                    Pay with Fastpay wallet
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="payment-method">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" checked="true" class="custom-control-input" id="payment-3" name="payment">
                                                    <label class="custom-control-label" for="payment-3">Cash on Delivery</label>
                                                </div>
                                                <div class="payment-content" id="payment-3-show">
                                                    <p>
                                                    Pay with cash on delivery.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart-btn">
                                            <button id="emptyCart">Empty Cart</button>
                                            <button id="orderCart">Place Order</button>
                                        </div>
                                        
                                    </div> 
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        }else{
            echo "<div class='alert alert-danger m-3'>no items in cart</div>";
        }
    }else{
        header("location:/?login=customer");
    }
    ?>
<!-- Cart End -->