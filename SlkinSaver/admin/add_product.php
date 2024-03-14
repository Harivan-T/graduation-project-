<?php 
    require_once("../connect.php");
    if(isset($_POST['add_product'])){

        //insert product information
        $product_name = $_POST['product_name']."<br>";
        $product_brand = (int)$_POST['product_brand'];
        $product_type = (int)$_POST['product_type'];
        $product_sale = (float)$_POST['product_sale_price'];
        $product_buy  = (float)$_POST['product_buy_price'];
        $product_amount = (int)$_POST['product_quantity'];
        $product_expire_date = $_POST['product_expire_date'];
        $product_description = $_POST['product_description'];
        $pro_query = @"INSERT INTO products(pro_name,pro_t_id,br_id,pro_amount,price_buy,price_sell,pro_description,pro_expire_date)
                                   VALUES (:pro_name,:pro_type,:pro_brand,:pro_amount,:pro_buy,:pro_sell,:pro_description,:pro_expire)";
        $add_product_query = $dbs->prepare($pro_query);
        $add_product_query->bindParam(":pro_name",$product_name);
        $add_product_query->bindParam(":pro_type",$product_type);
        $add_product_query->bindParam(":pro_brand",$product_brand);
        $add_product_query->bindParam(":pro_amount",$product_amount);
        $add_product_query->bindParam(":pro_buy",$product_buy);
        $add_product_query->bindParam(":pro_sell",$product_sale);
        $add_product_query->bindParam(":pro_description",$product_description);
        $add_product_query->bindParam(":pro_expire",$product_expire_date);
        if($add_product_query->execute()){
            $product_id = $dbs->lastInsertId();

        //insert product to categories
            if($_POST['categorySelected']){
                $cats = explode(',',$_POST['categorySelected']);
                foreach($cats as $cat){
                    $cat_query = @"INSERT INTO product_categories(product_cat_id,product_id) VALUES (:PCI,:PID)";
                    $add_product_cat_query = $dbs->prepare($cat_query);
                    $add_product_cat_query->bindParam(":PCI",$cat);
                    $add_product_cat_query->bindParam(":PID",$product_id);
                    $add_product_cat_query->execute();
                }
            }

        //insert product images
            $countfiles = count($_FILES['images']['name']);
            for($i=0;$i<$countfiles;$i++){
                $filename = time()."."."jpg";
                if($i===0){
                    $default = 1;
                }else{
                    $default = 0;
                }
                $insert_images_query = "INSERT INTO images (img_product_id,img_src,img_default) VALUES(:product_id,:image_name,:def)";
                    $statement = $dbs->prepare($insert_images_query);
                    $statement->bindParam(":product_id",$product_id);
                    $statement->bindParam(":image_name",$filename);
                    $statement->bindParam(":def",$default);
                if( $statement->execute()){
                    move_uploaded_file($_FILES['images']['tmp_name'][$i],'../products/'.$filename);
                    sleep(3);   //wait for uploading..
                }
            }
             echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product has been added successfully.</div>";
        }else{
             echo "<div class='alert alert-danger m-2 col-md-12' role='alert'>error in inserting data to database.</div>";
        }
         
    }
    ?>
    <div class="container bg-white">
        <div class="col-lg-12">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="/admin/?page=add_product" method="POST" enctype='multipart/form-data'>
                        <div class="modal-header">
                            <h5 class="modal-title"> <i class="fa fa-plus-square"></i> New Product </h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6  mt-3">
                                    <div class="form-group">
                                        <label for="product_name">Product name</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Brand</label>
                                        </div>
                                        <select class="custom-select" name="product_brand">
                                            <option selected>Choose Brand</option>
                                            <?php 
                                                $getBrandsQuery = $dbs->query("SELECT * FROM product_brand");
                                                $getBrandsQuery->execute();
                                                while($brands = $getBrandsQuery->fetch(PDO::FETCH_ASSOC)){
                                                    echo '<option value="'.$brands['br_id'].'">'.$brands['brand_name'].'</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Types</label>
                                        </div>
                                        <select class="custom-select" name="product_type">
                                            <option selected>Choose Type</option>
                                            <?php 
                                                $getTypesQuery = $dbs->query("SELECT * FROM product_type");
                                                $getTypesQuery->execute();
                                                while($type = $getTypesQuery->fetch(PDO::FETCH_ASSOC)){
                                                    echo '<option value="'.$type['pro_t_id'].'">'.$type['type'].'</option>';
                                                }
                                                ?>
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6  mt-3">
                                    <label for="images">Product Multiple Images</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" id="images" name="images[]" onchange="preview_images();" multiple multiple="multiple" class="custom-file-input"  aria-describedby="inputGroupFileAddon04">
                                                <label class="custom-file-label" for="images">Choose Images</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="image_preview"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <label for="basic-url">Sale Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="product_sale_price" class="form-control" aria-label="Amount (to the nearest dollar)">

                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="basic-url">Buy Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="product_buy_price" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="basic-url">Quantity</label>
                                    <div class="input-group mb-3">
                                        <input type="number" name="product_quantity" class="form-control" value="1" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="expire_date" >Expire Date</label>
                                    <div class="input-group date">
                                        <input type="text" name="product_expire_date" class="datepicker expire_date form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <label for="category" >Categories</label>
                                    <div class="input-group">
                                        <select class="custom-select" id="category" aria-label="Example select with button addon">
                                        <option selected value="0">Choose...</option>
                                            <?php 
                                                $productCatQuery = $dbs->query("SELECT * FROM categories");
                                                $productCatQuery->execute();
                                                while($cat = $productCatQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                                    <option value="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_name'];?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="add_category" type="button">Add category</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="added_categiries" >Added categories</label>
                                <div class="input-group">
                                        <select  id="categories" name="categories[]" class="custom-select" id="added_categiries">
                                            <option value="0">categories</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-danger" id="remove_category" type="button">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">product description</span>
                                </div>
                                <textarea class="form-control" name="product_description" aria-label="With textarea"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="add_product" class="btn btn-primary mb-2" value="Add Product">
                            <input type="reset" class="btn btn-danger  mb-2" value="Clear Form">
                            <input type="hidden" name="categorySelected" id="categorySelected">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 