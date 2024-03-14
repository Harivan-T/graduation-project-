<?php
require_once("header.php");
require_once("../connect.php");
$year = date("Y",time());//2022
$month = date("m",time());//02
$day = date("d",time());//02

$noP = $dbs->query("SELECT COUNT(pro_id) FROM products")->fetchColumn();
$noT = $dbs->query("SELECT COUNT(pro_t_id) FROM product_type")->fetchColumn();
$noB = $dbs->query("SELECT COUNT(br_id) FROM product_brand")->fetchColumn();
$noC = $dbs->query("SELECT COUNT(cust_id) FROM customer")->fetchColumn();
$noO = $dbs->query("SELECT * FROM orders");
$noNO = $dbs->query("SELECT * FROM orders WHERE  DAY(ord_date) = $day");

 $checkSystemQuery  = $dbs->query("SELECT * FROM settings WHERE setting_key='operating';");
 $checkSystemQuery->execute();
 $operating = $checkSystemQuery->fetch(PDO::FETCH_ASSOC)['setting_value'];

?>
<div class="container bg-white p-4">
    <div class="row pt-4">
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-folder"></i> Number of products</h5>
                    <h1><?php echo $noP;?></h1>
                    <a href="/admin/?page=edit_product" class="btn btn-info btn-sm">products</a>
                </div>
               
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-store"></i> Number of Types</h5>
                    <h1><?php echo $noT;?></h1>
                    <a href="/admin/?page=types" class="btn btn-danger btn-sm">Types</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-tags"></i> Number of brands</h5>
                    <h1><?php echo $noB;?></h1>
                   <a href="/admin/?page=brands" class="btn btn-success btn-sm">brands</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-users"></i> Number of customers</h5>
                    <h1><?php echo $noC;?></h1>
                   <a href="/admin/?page=customers" class="btn btn-dark btn-sm">customers</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-shipping-fast"></i> Number of orders</h5>
                    <h1> <?php echo $noO->rowCount();?></h1>
                    <a href="/admin/?page=orders" class="btn btn-primary btn-sm">orders</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-2">
            <div class="card border-secondary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-shipping-fast"></i> Today's orders</h5>
                    <h1>  <?php echo $noNO->rowCount();?> </h1>
                    <a href="/admin/?page=orders&today=yes" class="btn btn-secondary btn-sm">orders</a>
                </div>
            </div>
        </div>
         
    </div>
    <div class="row">
        <div class="col-lg-8 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-hammer"></i> Quick Actions</h5>
                    <a href="/admin/?page=add_product" class="btn btn-info btn-sm">New Product</a>
                    <a href="/admin/?page=types" class="btn btn-danger btn-sm">New type</a>
                    <a href="/admin/?page=brands" class="btn btn-success btn-sm">New brand</a>
                    <a href="/admin/?page=customers" class="btn btn-dark btn-sm">New customer</a>
                    <a href="/admin/?page=categories" class="btn btn-secondary btn-sm">New categories</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-power-off"></i> System Operations </h5>
                    <button action="<?php echo $operating=="1" ? "0" : "1";?>" class="btn shoutdown btn-sm <?php echo $operating=="1" ? " btn-danger " : " btn-success ";?> btn-block" type="button">
                       <?php 
                       if($operating=="1"){
                            echo "Power System Off";
                       }else{
                           echo "Power System On";
                       }
                       ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
require_once("footer.php");

    ?>