<?php 
if(isset($_SESSION['customer'])){
    $customerID = $_SESSION['customer_id'];
    $cartQuery = $dbs->query(@"SELECT products.*,images.*,wishlist.* 
                                FROM wishlist 
                                    LEFT JOIN products
                                        ON products.pro_id = wishlist.proID
                                    LEFT JOIN images
                                        ON images.img_product_id = wishlist.proID && images.img_default=1 
                                WHERE wishlist.custID=$customerID ORDER BY cartAdded DESC;");
    $cartQuery->execute();
   
    ?>
<!-- wishlist Start -->
<div class="cart-page">
    <div class="container-fluid">
       
        <div class="row">        
           
            <div class="col-lg-8">
                <h5 class="bg-white p-2"><i class="fa fa-heart"></i> Wishlist</h5>    
                <?php 
                if($cartQuery->rowCount()>0){
                    ?>
                    <div class="cart-page-inner">                      
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th colspan="2"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody class="align-top">
                                <?php  
                                    while($product = $cartQuery->fetch(PDO::FETCH_ASSOC)){
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
                                        <td><div class="qty"> <input type="text" value="<?php echo $product['pro_amount'];?>" disabled> </div></td>
                                        <td> <button class="deleteProduct"  id="<?php echo $product['cartID'];?>"><i class="fa fa-trash"></i></button> </td>
                                        <td> <button class="add_to_cart" id="<?php echo $product['pro_id'];?>" price="<?php echo $product['price_sell'];?>"><i class="fa fa-cart-plus"></i></button> </td>
                                    </tr>
                                <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php 
                    }else{
                    echo "<div class='alert alert-danger m-3'>no items in wishlist</div>";
                    }
                    ?>
            </div>
            <!-- Side Bar Start -->
            <div class="col-lg-4 sidebar">

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
<!-- wishlist End -->
<?php
         }else{
        header("location:/?login=customer");
    }
?>
