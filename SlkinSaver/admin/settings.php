<?php
require_once("header.php");
require_once("../connect.php");

//set as favourite
if(isset($_POST['setFavourite'])){
    $product_selected = $_POST['product'];
    $setQuery = $dbs->query("UPDATE settings SET setting_value=$product_selected WHERE setting_key='fav_product';");
    $setQuery->execute();
}

    $checkSystemQuery  = $dbs->query("SELECT * FROM settings WHERE setting_key='operating';");
    $checkSystemQuery->execute();
    $operating = $checkSystemQuery->fetch(PDO::FETCH_ASSOC)['setting_value'];

?>
<div class="container bg-white pt-4 pb-4">
    <div class="row ">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-heart"></i> Favourite product </h5>
                    <?php
                        $product_images = $dbs->query("SELECT * FROM images WHERE img_product_id=$fav_product AND img_default='1'");
                        $product_images->execute();
                        ?>  
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <?php 
                            $images = $product_images->fetch(PDO::FETCH_ASSOC); ?>
                            <img class="img img-fluid border border-primary" src="../products/<?php echo $images['img_src'];?>" alt="Product Image <?php echo $imagess['img_id'];?>">                                            
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <form action="/admin/?page=settings" method="POST"> 
                                <label for="product">Select product to make favourite</label>
                                <div class="input-group mt-2 mb-2">
                                    <select class="custom-select" name="product" id="product">
                                        <?php 
                                            $getTypesQuery = $dbs->query("SELECT * FROM products;");
                                            $getTypesQuery->execute();
                                                while($type = $getTypesQuery->fetch(PDO::FETCH_ASSOC)){
                                                    $sel = ($type['pro_id']==$images['img_product_id']) ? " selected " : " ";
                                                    echo "<option  value='".$type['pro_id']."' $sel>".$type['pro_name']."</option>";
                                                }
                                            ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" name="setFavourite" class="btn btn-primary"> <i class="fa fa-heart"></i> Set</button>
                                    </div>
                                </div> 
                            </form>
                            <div class="row mt-4">
                                    <div class="col-lg-12 col-md-6">
                                        <label for="product_default_image">Select product to set as default image </label>
                                        <div class="input-group mt-2 mb-2">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="product_default_image">Product</label>
                                            </div>
                                            <select class="custom-select" id="product_default_image">
                                                <?php 
                                                    $getTypesQuery = $dbs->query("SELECT * FROM products;");
                                                    $getTypesQuery->execute();
                                                        while($type = $getTypesQuery->fetch(PDO::FETCH_ASSOC)){
                                                            echo "<option  value='".$type['pro_id']."'>".$type['pro_name']."</option>";
                                                        }
                                                    ?>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div id="images_preview">
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
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
            <div class="card mt-2 pb-2">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-chart-area"></i> Targets </h5>

                    <label for="target_price">Price target</label>
                    <div class="input-group">
                        <input type="number" class="form-control"  id="target_price" value="<?php echo $target_price;?>">
                        <div class="input-group-append">
                            <button class="target btn btn-primary">Set</button>
                        </div>
                    </div> 
                    <label for="target_profit">Profit target</label>
                    <div class="input-group">
                        <input type="number" class="form-control"  id="target_profit" value="<?php echo $target_profit;?>">
                        <div class="input-group-append">
                            <button class="target btn btn-primary">Set</button>
                        </div>                        
                    </div> 
                    <label for="target_customers">Customer target</label>
                    <div class="input-group">
                         <input type="number" class="form-control"   id="target_customers" value="<?php echo $target_customers;?>">
                        <div class="input-group-append">
                            <button class="target btn btn-primary">Set</button>
                        </div>                       
                    </div> 
                    <label for="target_orders">Orders target</label>
                    <div class="input-group">
                        <input type="number" class="form-control"  id="target_orders" value="<?php echo $target_orders;?>">
                        <div class="input-group-append">
                            <button class="target btn btn-primary">Set</button>
                        </div>                        
                    </div> 
                    <label for="target_sales">Sales target</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="target_sales" value="<?php echo $target_sales;?>">
                        <div class="input-group-append">
                            <button class="target btn btn-primary" >Set</button>
                        </div>
                        
                    </div> 

                </div>
            </div>
        </div>

    </div>


<?php
require_once("footer.php");

    ?>