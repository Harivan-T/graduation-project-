<?php 
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
        //image product
        $product_images = $dbs->query("SELECT * FROM images WHERE img_product_id=$pro_id");
        $product_images->execute();

        ?>
        <!-- Product Detail Start -->
        <div class="product-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                    <?php 
                    if($productQuery->rowCount()>0){ 
                         $product = $productQuery->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="product-detail-top">
                            <div class="row align-items-center">
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
                                <div class="col-md-7">
                                    <div class="product-content">
                                        <div class="title"><h4> <?php echo $product['pro_name'];?> </h4></div>
                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
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
                                            <div class="updateQty">
                                                <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                                    <input type="text" id="quantity" value="1" disabled>
                                                <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <!-- <div class="p-size">
                                            <h4>Size:</h4>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn">S</button>
                                                <button type="button" class="btn">M</button>
                                                <button type="button" class="btn">L</button>
                                                <button type="button" class="btn">XL</button>
                                            </div> 
                                        </div>
                                        <div class="p-color">
                                            <h4>Color:</h4>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn">White</button>
                                                <button type="button" class="btn">Black</button>
                                                <button type="button" class="btn">Blue</button>
                                            </div> 
                                        </div> -->
                                        <div class="action">
                                            <a class="btn border-dark add_to_cart" id="<?php echo $product['pro_id'];?>" href="#"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                            <a class="btn btn-success" href="/?page=buynow&id=<?php echo $product['pro_id'];?>"><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- end product info -->    
                            </div>
                        </div>
                        <!-- description -->
                        <div class="row product-detail-bottom">
                            <div class="col-lg-12">
                                <h1>Description</h1>
                                <div class="tab-content">
                                    <div id="description" class="container tab-pane active">
                                        <h4>Product description</h4>
                                        <p>
                                            <?php echo nl2br($product['pro_description']);?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end description -->
                        <?php 
                    }else{
                            echo "<div class='alert alert-danger'>No product found!</div>";
                    }
                        ?>
                        <!-- related products -->
                        <div class="product">
                            <div class="section-header">
                                <h1>Related Products</h1>
                            </div>

                            <div class="row align-items-center product-slider product-slider-3">
                                <?php 
                                $query = "SELECT products.*,images.* 
                                    FROM products
                                        LEFT JOIN images 
                                            ON  images.img_product_id = products.pro_id && images.img_default=1
                                        ORDER BY pro_id DESC LIMIT 4";
                                $productQuery = $dbs->query($query);
                                $productQuery->execute();
                                while($product = $productQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                <div class="col-lg-3">
                                    <div class="product-item">
                                        <div class="product-title">
                                        <a href="/?page=product&id=<?php echo $product['pro_id'];?>"><?php echo $product['pro_name'];?></a>
                                        </div>
                                        <div class="product-image">
                                            <img src="products/<?php echo $product['img_src'];?>" alt="Product Image">                                        
                                            <div class="product-action">
                                                <a href="#" class="add_to_cart" id="<?php echo $product['pro_id'];?>" price="<?php echo $product['price_sell'];?>"><i class="fa fa-cart-plus"></i></a>
                                                <a href="#" class="add_to_wishlist"  id="<?php echo $product['pro_id'];?>"><i class="fa fa-heart"></i></a>
                                                <a href="/?page=product&id=<?php echo $product['pro_id'];?>"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-price">
                                            <h3><span>$</span><?php echo $product['price_sell'];?></h3>
                                            <a class="btn btn-success" href="/?page=buynow&id=<?php echo $product['pro_id'];?>"><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                                 <?php   }  ?>
                            </div>
                        </div>
                        <!-- end related products -->
                    </div>
                    
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget brands">
                            <h2 class="title">Favourite product</h2>
                                <?php
                                    $product_images = $dbs->query("SELECT * FROM images WHERE img_product_id=$fav_product ORDER BY img_default DESC;");
                                    $product_images->execute();
                                    ?>  
                            <!-- product gallery -->    
                            <div class="col-lg-12">
                                <div class="product-fav-single normal-slider">
                                    <?php  while($images = $product_images->fetch(PDO::FETCH_ASSOC)){ ?> 
                                        <img src="products/<?php echo $images['img_src'];?>" alt="Product Image <?php echo $images['img_id'];?>">
                                    <?php   } ?>
                                </div>
                                <div class="product-fav-single-nav normal-slider">
                                    <?php while($images = $product_images->fetch(PDO::FETCH_ASSOC)){ ?>
                                        <div class="slider-nav-img">                                            
                                            <img src="products/<?php echo $images['img_src'];?>" alt="Product Image <?php echo $imagess['img_id'];?>">                                            
                                        </div>
                                    <?php   } ?>
                                </div>
                                <?php 
                                    $getFavProduct = $dbs->query("SELECT * FROM products WHERE pro_id=$fav_product;");
                                    $getFavProduct->execute();
                                    $productFav = $getFavProduct->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <h2><sup>$</sup><?php echo $productFav['price_sell'];?></h2>
                                    <a href="/?page=product&id=<?php echo $productFav['pro_id'];?>"> <?php echo $productFav['pro_name'];?> </a>
                            </div>
                            <!-- end product gallery -->                          
                        </div>
                        <div class="sidebar-widget category">
                            <h2 class="title">Categories</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <?php 
                                        $productCatQuery = $dbs->query("SELECT * FROM categories");
                                        $productCatQuery->execute();
                                        while($cat = $productCatQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?category=<?php echo $cat['cat_id'];?>"><i class="fa fa-circle"></i><?php echo $cat['cat_name'];?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="sidebar-widget brands">
                            <h2 class="title">Brands</h2>
                            <ul>
                                <?php 
                                $productBrandQuery = $dbs->query("SELECT * FROM product_brand");
                                $productBrandQuery->execute();
                                
                                while($brand = $productBrandQuery->fetch(PDO::FETCH_ASSOC)){ 
                                    $brand_id = $brand['br_id'];
                                    $totalBrands = $dbs->query("SELECT COUNT(pro_id) FROM products WHERE br_id=$brand_id")->fetchColumn(); 
                                    ?>
                                <li><a href="/?brand=<?php echo $brand['br_id'];?>"><?php echo $brand['brand_name'];?> </a><span>(<?php echo $totalBrands;?>)</span></li>
                            <?php } ?>
                            </ul>
                        </div>
                        
                        <div class="sidebar-widget tag">
                            <h2 class="title">Tags Cloud</h2>
                            <?php 
                                $productTypesQuery = $dbs->query("SELECT * FROM product_type");
                                $productTypesQuery->execute();
                                while($type = $productTypesQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <a href="/?type=<?php echo $type['pro_t_id'];?>"><?php echo $type['type'];?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Product Detail End -->
