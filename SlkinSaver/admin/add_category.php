<?php 
    require_once("header.php");
    require_once("../connect.php");

    //add cat
    if(isset($_POST['add_category'])){ 
        $cat_name = $_POST['catName'];
        $cat_image = $_POST['catImage'];
        $cat_descriptyion = $_POST['catDesc'];
        $cat_id = $_POST['catID'];
        $filename = time().'.'.'jpg';
        if(move_uploaded_file($_FILES['images']['tmp_name'],'../categories/'.$filename)){
            if($cat_name !==null && !empty($cat_name)){
                $pro_query = @"INSERT INTO categories (cat_name,cat_image,cat_parent,cat_description) VALUES (:CN,:CI,:CP,:DS)";
                $add_cat_query = $dbs->prepare($pro_query);
                $add_cat_query->bindParam(":CN",$cat_name); 
                $add_cat_query->bindParam(":CI",$filename); 
                $add_cat_query->bindParam(":CP",$cat_id); 
                $add_cat_query->bindParam(":DS",$cat_descriptyion); 
                    if($add_cat_query->execute()){                 
                        echo "<div class='alert alert-success m-2 col-md-12' role='alert'>category  has been added.</div>";
                    }else{
                        echo "Error:";
                        print_r($dbs->errorInfo());
                    }
            }else{
                echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,insert category name.</div>";
            }
        }else{
            echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Image has not been uploaded.</div>";
        }

    }

    //edit cat
      if(isset($_POST['edit_type'])){
        // $types = (int)$_POST['types'];
        // $product_type = $_POST['product_type'];
        //  if($types !==0){
        //     $pro_query = @"UPDATE product_type SET type=:TP WHERE pro_t_id=:TID";
        //     $add_product_query = $dbs->prepare($pro_query);
        //     $add_product_query->bindParam(":TP",$product_type);
        //     $add_product_query->bindParam(":TID",$types);
        //         if($add_product_query->execute()){
        //             echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product type has been up to date.</div>";
        //         }else{
        //             echo "Error: ";
        //             print_r($dbs->errorInfo());
        //         }
        //  }else{
        //     echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select type to update.</div>";
        //  }
      }

    //delete cat
    //   if(isset($_POST['delete_type'])){
    //     $types = (int)$_POST['types'];
    //     if($types !==0){
    //         $pro_query = @"DELETE FROM product_type  WHERE pro_t_id=:TID";
    //         $add_product_query = $dbs->prepare($pro_query);
    //         $add_product_query->bindParam(":TID",$types);
    //             if($add_product_query->execute()){
    //                 echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product type has been deleted.</div>";
    //             }else{
    //                 echo "Error: ";
    //                 print_r($dbs->errorInfo());
    //             }
    //     }else{
    //         echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select type to deleted.</div>";
    //     }
    //   }
    
    ?>
    <!-- add categories -->
<div class="container bg-white">      
    <div class="col-md-8">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/admin/?page=categories" method="POST"  enctype='multipart/form-data'>
                    <div class="modal-header">
                        <h5 class="modal-title"> <i class="fa fa-layer-group"></i> Categories </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="catID">Categories</label>
                                    </div>
                                    <select class="custom-select" name="catID" id="catID">
                                        <option selected value="0">Choose...</option>
                                        <?php 
                                            $productCatQuery = $dbs->query("SELECT * FROM categories");
                                            $productCatQuery->execute();
                                            while($cat = $productCatQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                                <option value="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6  mt-3">
                                <label for="images">Category Image</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="images" name="images" onchange="preview_images();"  class="custom-file-input" aria-describedby="images">
                                            <label class="custom-file-label" for="images">Choose image</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="image_preview"></div>
                            </div>
                            <div class="col-6  mt-3">
                                <div class="form-group">
                                    <label for="catName">Category name</label>
                                    <input type="text" class="form-control" name="catName" id="catName" aria-describedby="catName">
                                </div>

                                
                            </div>
                            
                        </div>
                    
                        <div class="form-group mt-3 mb-3">
                            <label for="catDesc">Category Description</label>
                            <textarea class="form-control" name="catDesc" id="catDesc"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <input type="submit" name="add_category" value="Add Category" class="btn btn-primary mt-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
    <!-- add products to categories -->
<?php 
    require_once("footer.php");
    ?>