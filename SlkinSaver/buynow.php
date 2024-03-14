<?php 
if(isset($_SESSION['customer'])){
$pro_id = isset($_GET['id']) ? $_GET['id'] : 0;
$query = "SELECT products.*,images.*,product_brand.*
                FROM products
                    LEFT JOIN images 
                        ON  images.img_product_id = products.pro_id && images.img_default=1
                    LEFT JOIN product_brand
                        ON  product_brand.br_id = products.br_id
                WHERE pro_id = $pro_id";
        $productQuery = $dbs->query($query);
        $productQuery->execute();

        //shipping cost
        $shippingCost = 10;
        //image product
        $product_images = $dbs->query("SELECT * FROM images WHERE img_product_id=$pro_id");
        $product_images->execute();

        if($productQuery->rowCount()>0){
        ?>
    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 pt-0 product-detail">
                      <?php 
                    if($productQuery->rowCount()>0){ 
                         $product = $productQuery->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="product-detail-top">
                            <div class="row ">
                                <!-- product gallery -->    
                                <div class="col-md-5">
                                    <div class="product-slider-single normal-slider">
                                        <?php  while($images = $product_images->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <img src="products/<?php echo $images['img_src'];?>" alt="Product Image <?php echo $images['img_id'];?>">
                                        <?php   } ?>
                                    </div>
                                    <div class="product-slider-single-nav normal-slider">
                                        <?php while($imagess = $product_images->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <div class="slider-nav-img"><img src="products/<?php echo $imagess['img_src'];?>" alt="Product Image <?php echo $imagess['img_id'];?>"></div>
                                        <?php   } ?>
                                    </div>
                                </div>
                                <!-- end product gallery -->

                                <!-- product info -->    
                                <div class="col-lg-7">
                                    <div class="product-content">
                                        <div class="title"><h4> <?php echo $product['pro_name'];?> </h4></div>
                                         
                                        <div class="price">
                                            <h4>Brand:</h4>
                                            <p><a href="/?brand=<?php echo $product['br_id'];?>"><?php echo $product['brand_name'];?> </a></p>
                                        </div>
                                        <div class="price">
                                            <h4>In Stock:</h4>
                                            <p><?php echo ((int)$product['pro_amount']>0) ? $product['pro_amount']." <sub><small class='text-success'> items </small></sub>" :"<small class='text-danger'>Not Available</small>";?> </p>
                                        </div>
                                        
                                        <div class="price">
                                            <h4>Price:</h4>
                                            <p>$<?php echo $product['price_sell'];?> </p>
                                        </div>
                                        <div class="quantity">
                                            <h4>Quantity:</h4>
                                            <div class="updateQty buynow">
                                                <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                                    <input type="text" id="quantity" value="1" disabled>
                                                <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="product_id" value="<?php echo $pro_id;?>">
                                        <input type="hidden" id="product_price" value="<?php echo $product['price_sell'];?>">
                                    </div>
                                </div>
                                <!-- end product info -->    
                            </div>
                        </div>
                        
                        <?php 
                    }else{
                            echo "<div class='alert alert-danger'>No product found!</div>";
                    }
                        ?>           
                </div>
                <div class="col-lg-4">
                    <div class="cart-page-inner">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2>Order product</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h2>Order Summary</h2>
                                        <p>Sub Total<span id="subtotal"></span></p>
                                        <p>Shipping Cost<span>$<?php echo $shippingCost;?></span></p>
                                        <h2>Grand Total<span id="grandtotal"></span></h2>
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
                                        <div class="cart-btns m-2">
                                            <button class="btn btn-success btn-block" id="buynow">Place Order</button>
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
                // echo "Please,login or register!";
            }
    ?>
<!-- Cart End -->