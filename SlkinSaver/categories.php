<?php $cat_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;?>
<!-- Product List Start -->
<div class="product-view">
    <div class="container-fluid">
        <div class="row">
            <?php 
                $nbOfResults = $dbs->query("SELECT COUNT(*) FROM product_categories WHERE product_cat_id=$cat_id")->fetchColumn();
                if($nbOfResults>0){
                    $entitiesPerPage = 8; 
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
                            'link' => '?category='.$cat_id.'&pg=' . ($currentPage - 1),
                            'active' => false,
                        ];
                    }

                    for($i = 1; $i <= $nbOfPages; $i++) {
                        $pagination[] = [
                            'page' => $i,
                            'link' => '?category='.$cat_id.'&pg=' . $i,
                            'active' => ( $i === $currentPage ),
                        ];
                    }

                    if ($currentPage+1 !== $nbOfPages) {
                        $pagination[] = [
                            'page' => 'Next',
                            'link' => '?category='.$cat_id.'&pg=' . ($currentPage + 1),
                            'active' => false,
                        ];
                    }
                        $defualt = 1;  
                        $to = (int)(($currentPage-1 ) * $entitiesPerPage);

                        $productCatQuery = $dbs->query(@"
                                    SELECT product_categories.*,categories.*,products.*,images.*
                                        FROM product_categories
                                            LEFT JOIN categories
                                                ON categories.cat_id = product_categories.product_cat_id
                                            LEFT JOIN products
                                                ON products.pro_id = product_categories.product_id   
                                            LEFT JOIN images 
                                                ON  images.img_product_id = products.pro_id && images.img_default=1
                                        WHERE product_categories.product_cat_id=$cat_id
                                        ORDER BY pro_cat_id LIMIT $entitiesPerPage OFFSET $to  ");
                                        
                        $productCatQuery->execute();
                        while($product = $productCatQuery->fetch(PDO::FETCH_ASSOC)){
                        ?>
                            <div class="col-md-3">
                                <div class="product-item">
                                    <div class="product-title">
                                        <a href="/?page=product&id=<?php echo $product['pro_id'];?>">
                                            <?php echo $product['pro_name'];?>
                                        </a>
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
                }else{
                        echo "no products";
                } 
            ?> 
        </div>
    </div>
</div>
<!-- Product List End -->



