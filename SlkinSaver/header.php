<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Save Skin </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php if($systemOff){ ?>
        <div class='alert alert-danger fixed-bottom'> <i class='fa fa-power-off'></i> System is shoutdown!</div>
            <?php } ?>
    <!-- Bottom Bar Start -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-4 col-4">
                    <div class="logo">
                        <a href="/">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-4 col-8 mt-3">
                    <div class="search" >
                        <input type="text" class="form-control" id="popup-reference" placeholder="Search..." aria-label="Search">
                        <button disabled><i class="fa fa-search"></i></button>
                    </div>
                    <div class="list-group shadow" id="popup" style="margin:0 auto;width:95%;"></div>
                </div>
                <?php 
                    if(isset($_SESSION['customer'])){
                        $cust_id = $_SESSION['customer_id'];
                        $cartsItems = $dbs->query("SELECT COUNT(cartID) FROM  carts WHERE custID=$cust_id")->fetchColumn();
                        $wishlistItems = $dbs->query("SELECT COUNT(cartID) FROM  wishlist WHERE custID=$cust_id")->fetchColumn();
                    ?>
                <div class="col-md-3 col-lg-3 col-sm-4 col-8">
                    <div class="user">
                        <a href="/?page=wishlist" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                          <span id="wishlist">(<?php echo $wishlistItems;?>)</span>
                        </a>
                        <a href="/?page=cart" class="btn cart">
                            <i class="fa fa-shopping-bag"></i>
                            <span id="cart">(<?php echo $cartsItems;?>)</span>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Nav Bar Start -->
    <div class="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="/" class="nav-item nav-link"> <i class="fa fa-home"></i> Home</a>
                        <?php
                        if(isset($_SESSION['customer'])){
                            echo '  <a href="/?page=wishlist" class="nav-item nav-link "> <i class="fa fa-heart"></i> Wishlist</a>
                                    <a href="/?page=cart" class="nav-item nav-link "> <i class="fa fa-shopping-bag"></i> Cart</a> 
                                    <a href="/?page=orders" class="nav-item nav-link "> <i class="fa fa-shipping-fast"></i> My orders</a>';  
                            }
                            ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-layer-group"></i> Product Types </a>
                            <div class="dropdown-menu">
                            <?php 
                                $productTypesQuery = $dbs->query("SELECT * FROM product_type");
                                $productTypesQuery->execute();
                                while($type = $productTypesQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                        <a href="/?type=<?php echo $type['pro_t_id'];?>" class="dropdown-item"><?php echo $type['type'];?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-tags"></i> Brands </a>
                            <div class="dropdown-menu">
                            <?php 
                                $productBrandQuery = $dbs->query("SELECT * FROM product_brand");
                                $productBrandQuery->execute();
                                while($brand = $productBrandQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                        <a href="/?brand=<?php echo $brand['br_id'];?>" class="dropdown-item"><?php echo $brand['brand_name'];?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-list"></i> Categories </a>
                            <div class="dropdown-menu" style="height:80vh;overflow:scroll;">
                            <?php 
                                $productCatQuery = $dbs->query("SELECT * FROM categories");
                                $productCatQuery->execute();
                                while($cat = $productCatQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                        <a href="/?category=<?php echo $cat['cat_id'];?>" class="dropdown-item" id="dropdownMenuOffset"><?php echo $cat['cat_name'];?></a>
                                        <?php if(!empty($cat['cat_description'])){ ?>
                                            <p style="margin:0 5px 0 5px;font-size:80%;"><?php  echo $cat['cat_description'];?></p>
                                        <?php } ?>
                                        <img src="/categories/<?php  echo $cat['cat_image'];?>" width="200" alt="no image">

                            <?php } ?>
                            </div>
                          
                        </div>
                    </div>
                     <?php if(isset($_SESSION['customer'])){ ?>
                    <div class="navbar-nav">
                       <a class="nav-item nav-link text-lowercase"> <i class="fa fa-user"> </i> <?php echo "Welcome ".$_SESSION['first_name'];?></a>
                        <a href="?logout=customer" class="nav-item nav-link"><i class="fa fa-sign-out-alt"></i></a>
                    </div>
                     <?php }else{
                 

                            // if(!isset($_SESSION['customer'])){
                                echo '  <a href="/?login=customer" class="nav-item nav-link"> <i class="fa fa-user-lock"></i> Login & Register</a>';
                            // }else{
                            //     echo '  <a href="/?page=wishlist" class="nav-item nav-link "> <i class="fa fa-heart"></i> Wishlist</a>
                            //             <a href="/?page=cart" class="nav-item nav-link "> <i class="fa fa-shopping-bag"></i> Cart</a> 
                            //             <a href="/?page=orders" class="nav-item nav-link "> <i class="fa fa-shipping-fast"></i> My orders</a>';  
                            // }
                     }
                      ?>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->


 