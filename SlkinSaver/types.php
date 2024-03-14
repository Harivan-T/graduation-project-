<?php $br_id = isset($_GET['type']) ? $_GET['type'] : 0;?>
<!-- Product List Start -->
<div class="product-view mt-0 pt-0">
    <div class="container">
        <div class="row bg-white pt-4">
            <div class="col-lg-8">
                <div class="row">
                    <?php 
                    $nbOfResults = $dbs->query("SELECT COUNT(*) FROM products WHERE pro_t_id=$br_id")->fetchColumn();
                    if($nbOfResults>0){
                        $entitiesPerPage = 9; 
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
                                'link' => '?type='.$br_id.'&pg=' . ($currentPage - 1),
                                'active' => false,
                            ];
                        }

                        for($i = 1; $i <= $nbOfPages; $i++) {
                            $pagination[] = [
                                'page' => $i,
                                'link' => '?type='.$br_id.'&pg=' . $i,
                                'active' => ( $i === $currentPage ),
                            ];
                        }

                        if ($currentPage+1 !== $nbOfPages) {
                            $pagination[] = [
                                'page' => 'Next',
                                'link' => '?type='.$br_id.'&pg=' . ($currentPage + 1),
                                'active' => false,
                            ];
                        }
                        $defualt = 1;  
                        $to = (int)(($currentPage-1 ) * $entitiesPerPage);

                        $productQuery = $dbs->query(@"
                                    SELECT products.*,images.* 
                                        FROM products
                                            LEFT JOIN images 
                                                ON  images.img_product_id = products.pro_id && images.img_default=1
                                                WHERE pro_t_id=$br_id
                                                
                                        ");
                        $productQuery->execute();
                        while($product = $productQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                            <div class="col-md-4">
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
        
                        <?php 
                        }
                        if($nbOfResults>$entitiesPerPage){ ?>
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
                    }else{
                        echo "<div class='alert alert-danger m-2 col-md-12' role='alert'>No products for this type!.</div>";
                    }
                    ?>  
                </div>
            </div>
                        <!-- Side Bar Start -->
            <div class="col-lg-4 sidebar">
                <div class="sidebar-widget brands  pt-0">
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
                                <a class="nav-link" href="?category=<?php echo $cat['cat_id'];?>"><i class="fa fa-tram"></i><?php echo $cat['cat_name'];?></a>                                
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
<!-- Product List End -->



