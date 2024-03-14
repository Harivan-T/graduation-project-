<?php 
    require_once("../connect.php");

    if(isset($_POST['update_product'])){

        //insert product information
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name']."<br>";
        $product_brand = (int)$_POST['product_brand'];
        $product_type = (int)$_POST['product_type'];
        $product_sale = (float)$_POST['product_sale_price'];
        $product_buy  = (float)$_POST['product_buy_price'];
        $product_amount = (int)$_POST['product_quantity'];
        $product_expire_date = $_POST['product_expire_date'];
        $product_description = $_POST['product_description'];

        // //insert product to categories
            if($_POST['categorySelected']){
                $cats = explode(',',$_POST['categorySelected']);
                foreach($cats as $cat){
                  $check_cat = $dbs->prepare("SELECT * FROM product_categories WHERE product_cat_id=:CAT AND product_id=:PID");
                  $check_cat->bindParam(':CAT',$cat);
                  $check_cat->bindParam(':PID',$product_id);
                  $check_cat->execute();
                  if($check_cat->rowCount()<=0){
                    $cat_query = @"INSERT INTO product_categories(product_cat_id,product_id) VALUES (:PCI,:PID)";
                    $add_product_cat_query = $dbs->prepare($cat_query);
                    $add_product_cat_query->bindParam(":PCI",$cat);
                    $add_product_cat_query->bindParam(":PID",$product_id);
                    $add_product_cat_query->execute();
                  }
                }
            }

        $pro_query = @"UPDATE products SET pro_name=:pro_name,pro_t_id=:pro_type,br_id=:pro_brand,pro_amount=:pro_amount,price_buy=:pro_buy,price_sell=:pro_sell,pro_description=:pro_description,pro_expire_date=:pro_expire
                       WHERE pro_id=:PID";
        $add_product_query = $dbs->prepare($pro_query);
        $add_product_query->bindParam(":pro_name",$product_name);
        $add_product_query->bindParam(":pro_type",$product_type);
        $add_product_query->bindParam(":pro_brand",$product_brand);
        $add_product_query->bindParam(":pro_amount",$product_amount);
        $add_product_query->bindParam(":pro_buy",$product_buy);
        $add_product_query->bindParam(":pro_sell",$product_sale);
        $add_product_query->bindParam(":pro_description",$product_description);
        $add_product_query->bindParam(":pro_expire",$product_expire_date);
        $add_product_query->bindParam(":PID",$product_id);
        if($add_product_query->execute()){
        //insert product images
            $countfiles = count($_FILES['images']['tmp_name']);
                // echo "<pre>";
                //    var_dump($_FILES['images']['tmp_name']);
                // echo "</pre>";     
                 
            for($i=0;$i<$countfiles;$i++){
                $filename = time()."."."jpg";
                $default = 0;
                $tmp = $_FILES['images']['tmp_name'][$i];
                $insert_images_query = "INSERT INTO images (img_product_id,img_src,img_default) VALUES(:product_id,:image_name,:def)";
                    $statement = $dbs->prepare($insert_images_query);
                    $statement->bindParam(":product_id",$product_id);
                    $statement->bindParam(":image_name",$filename);
                    $statement->bindParam(":def",$default);
                if( $statement->execute()){
                    @move_uploaded_file($tmp,'../products/'.$filename);
                    // sleep(2);   //wait for uploading..
                }
            }
            
             echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product has been up to date successfully.</div>";
        }else{
             echo "<div class='alert alert-danger m-2 col-md-12' role='alert'>error in updating product!.</div>";
        }
         
    }

    ?>
    <div class="container bg-white">
        <div class="col-lg-12  mt-3">
            <form action="/admin/?page=edit_product" method="POST" enctype='multipart/form-data'>
                <div class="row">
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
                    <div class="mb-2">
                        <input type="submit" name="select_product" class="btn btn-primary mb-2" value="Select Product types">
                    </div>
                <?php
                    if(isset($_POST['select_product'])){
                        $product_type = $_POST['product_type'];
                    ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Product</label>
                            </div>
                            <select class="custom-select" name="product">
                                <?php 
                                    $getTypesQuery = $dbs->query("SELECT * FROM products WHERE pro_t_id=$product_type;");
                                    $getTypesQuery->execute();
                                        while($type = $getTypesQuery->fetch(PDO::FETCH_ASSOC)){
                                            echo '<option value="'.$type['pro_id'].'">'.$type['pro_name'].'</option>';
                                        }
                                    ?>
                            </select>
                        </div> 
                    <div class="mb-2">
                        <input type="submit" name="edit_product" class="btn btn-primary mb-2" value="Edit Product">
                    </div>                    
                    <?php 
                        } 
                        ?>    
            
                </div>
            
            </form>
        </div>
    <?php 
        if(isset($_POST['edit_product'])){
            $product_selected = $_POST['product'];
            //get product infos
            $productQuery = $dbs->prepare("SELECT products.*,images.* 
                                FROM products
                                    LEFT JOIN images 
                                        ON  images.img_product_id = products.pro_id && images.img_default=1
                                WHERE pro_id=:PID");
            $productQuery->bindParam(':PID',$product_selected);
            $productQuery->execute();
            $product = $productQuery->fetch(PDO::FETCH_ASSOC);
        ?>
    
        <div class="col-lg-12 mb-2">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="/admin/?page=edit_product" method="POST" enctype='multipart/form-data'>
                        <div class="modal-header">
                            <h5 class="modal-title"> <i class="fa fa-pen"></i> Update Product </h5>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="product_id" id="product_id" value="<?php echo  $product_selected;?>">
                            <div class="row">
                                <div class="col-6  mt-3">
                                    <div class="form-group">
                                        <label for="product_name">Product name</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $product['pro_name'];?>">
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
                                                    $sel = $product['br_id']==$brands['br_id'] ? ' selected' :' ';
                                                    echo '<option value="'.$brands['br_id'].'"'.$sel.'>'.$brands['brand_name'].'</option>';
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
                                                    $sel = $product['pro_t_id']==$type['pro_t_id'] ? ' selected' :' ';
                                                    echo '<option value="'.$type['pro_t_id'].'"'.$sel.'>'.$type['type'].'</option>';
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
                                                <input type="file" id="images" name="images[]" onchange="preview_images();" multiple  class="custom-file-input"  aria-describedby="inputGroupFileAddon04">
                                                <label class="custom-file-label" for="images">Choose Images</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="image_preview">
                                        <?php 
                                                $productimagesQuery = $dbs->query("SELECT * FROM images WHERE img_product_id=$product_selected");
                                                $productimagesQuery->execute();
                                                while($cat = $productimagesQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                                    <div id="img_id_<?php echo $cat['img_id'];?>" style="margin:2px;padding:2px;float:left;">                                        
                                                        <img class="img img-responsive m-1" height="80px" src="../products/<?php echo $cat['img_src'];?>" alt="image">
                                                        <div style="text-align:center;">
                                                            <button onclick="deleteImage(<?php echo $cat['img_id'];?>);" type="button" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <label for="basic-url">Sale Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" value="<?php echo $product['price_sell'];?>" name="product_sale_price" class="form-control">

                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="basic-url">Buy Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" value="<?php echo $product['price_buy'];?>"  name="product_buy_price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="basic-url">Quantity</label>
                                    <div class="input-group mb-3">
                                        <input type="number" value="<?php echo $product['pro_amount'];?>" name="product_quantity" class="form-control" value="1" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="expire_date" >Expire Date</label>
                                    <div class="input-group date">
                                        <input type="text"  value="<?php echo $product['pro_expire_date'];?>" name="product_expire_date" class="datepicker expire_date form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <label for="category" >Categories</label>
                                    <div class="input-group">
                                        <select class="custom-select" id="category" aria-label="Example select with button addon">
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
                                    <label for="categories" >Added categories</label>
                                    <div class="input-group">
                                        <select  id="categories" name="categories[]" class="custom-select ">
                                            <?php 
                                                $productCatQuery = $dbs->query(@
                                                    "SELECT product_categories.*,categories.* 
                                                        FROM product_categories
                                                            LEFT JOIN categories
                                                                ON product_categories.product_cat_id = categories.cat_id
                                                        WHERE product_categories.product_id = $product_selected");
                                                $productCatQuery->execute();                                            
                                                while($cat = $productCatQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                                    <option value="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_name'];?></option>
                                            <?php } ?>
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
                                <textarea class="form-control" name="product_description" aria-label="With textarea"><?php echo $product['pro_description'];?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="update_product" class="btn btn-primary mb-2" value="Update Product">
                            <input type="reset" class="btn btn-danger  mb-2" value="Clear Form">
                            <input type="hidden" name="categorySelected" id="categorySelected">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
        }
        ?>
     </div>