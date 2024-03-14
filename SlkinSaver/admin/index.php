<?php
    ob_start();
    session_start();
if(isset($_SESSION['admin'])){
    require_once("header.php");
        if(isset($_GET['page'])){
            $p = $_GET['page'];
            switch($p){
                case "add_product" :
                    require_once("add_product.php");
                    break;
                case "edit_product" :
                    require_once("edit_product.php");
                    break;
                case "brands" :
                    require_once("add_brands.php");
                    break;
                case "types" :
                    require_once("add_types.php");
                    break;
                case "categories" :
                    require_once("add_category.php");
                    break;
                case "customers" :
                    require_once("customers.php");
                    break;
                case "reports" :
                    require_once("reports.php");
                    break;
                case "orders" :
                    require_once("orders.php");
                    break;
                case "settings" :
                    require_once("settings.php");
                    break;

                    default :
                        require_once("home.php");
            }
        }else{
            require_once("home.php");
        }
    require_once("footer.php");
}else{
    require_once("../adminLogin.php");
}
    ?>