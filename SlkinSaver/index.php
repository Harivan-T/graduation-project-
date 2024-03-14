<?php
    ob_start();
    session_start();
require_once('connect.php');

 //logout
if(isset($_GET['logout'])){
    if($_GET['logout']=="customer"){
            $_SESSION['customer']=null;
            $_SESSION['first_name']=null;
            $_SESSION['customer_id']=null;
            unset($_SESSION['customer']);
            unset($_SESSION['first_name']);
            unset($_SESSION['customer_id']);
            header("location:/");
    }else if($_GET['logout']=="admin"){
            $_SESSION['admin']=null;
            unset($_SESSION['admin']);
            unset($_SESSION['name']);
            header("location:/");
    }
} 
//login
if(isset($_GET['login'])){
    if($_GET['login']=="customer"){
        require_once("login.php");
    }else if($_GET['login']=="admin"){
        require_once("adminLogin.php");
    }else if($_GET['login']="register"){
        require_once("register.php");
    }

}else{

    $systemOff = false; 
    if($operating=="1" || isset($_SESSION['admin'])){

        if($operating=="0"){
            $systemOff = true;
        }

        if(isset($_GET['brand'])){
            require_once("header.php");   
            require_once("brands.php");   
            require_once("footer.php");   

        }else if(isset($_GET['type'])){
            require_once("header.php");   
            require_once("types.php");   
            require_once("footer.php");   

        }else if(isset($_GET['category'])){

            require_once("header.php");   
            require_once("categories.php");   
            require_once("footer.php");  

        }else{
            
            if(isset($_GET['page'])){
                require_once("header.php");    
                $p  = $_GET['page'];
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                switch($p){

                    case "product" :
                        require_once("product.php");
                        break;

                    case "cart" :
                        require_once("cart.php");
                        break;

                    case "wishlist" :
                        require_once("wishlist.php");
                        break;

                    case "orders" :
                        require_once("orders.php");
                        break;

                    case "buynow" :
                        require_once("buynow.php");
                        break;
                        
                        default :
                            require_once("home.php");
                }
            require_once("footer.php"); 
            }else{
                require_once("header.php");   
                    require_once("home.php");
                require_once("footer.php");   
            }

        }
    }else{
        require_once("shoutdown.php");   
            echo "<div class='alert alert-danger'> <i class='fa fa-power-off'></i> The System has been shutting down!</div>";
    }
    $dbs = null;
}
 
    ?>