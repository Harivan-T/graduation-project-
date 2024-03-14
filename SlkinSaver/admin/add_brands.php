<?php 
    require_once("../connect.php");

    //add brand
    if(isset($_POST['add_brand'])){ 
        $product_brand = $_POST['product_brand'];
        if($product_brand !==null && !empty($product_brand)){
            $pro_query = @"INSERT INTO product_brand (brand_name) VALUES (:pro_brand)";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":pro_brand",$product_brand); 
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product brand has been added.</div>";
                }else{
                    echo "Error:";
                    print_r($dbs->errorInfo());
                }
        }else{
              echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,insert brand name to add.</div>";
        }
    }

    //edit brands
      if(isset($_POST['edit_brand'])){
        $brands = (int)$_POST['brands'];
        $product_brand = $_POST['product_brand'];
         if($brands !==0){
            $pro_query = @"UPDATE product_brand SET brand_name=:TP WHERE br_id=:TID";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":TP",$product_brand);
            $add_product_query->bindParam(":TID",$brands);
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product brand has been up to date.</div>";
                }else{
                    echo "Error: ";
                    print_r($dbs->errorInfo());
                }
         }else{
            echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select brand to update.</div>";
         }
      }

    //delete brands
      if(isset($_POST['delete_brand'])){
        $brands = (int)$_POST['brands'];
        if($brands !==0){
            $pro_query = @"DELETE FROM product_brand  WHERE br_id=:TID";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":TID",$brands);
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product brand has been deleted.</div>";
                }else{
                    echo "Error: ";
                    print_r($dbs->errorInfo());
                }
        }else{
            echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select brand to deleted.</div>";
        }
      }


    ?>
<div class="container bg-white">      
    <div class="col-md-8">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/admin/?page=brands" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title"> <i class="fa fa-tags"></i> Brands </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group col-md-6">
                                    <label for="product_brand">Product Brand Name</label>
                                    <input type="text" class="form-control" name="product_brand" aria-describedby="productHelp">
                                </div>
                                
                                <div class="input-group mb-3 col-md-6">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Brands</label>
                                    </div>
                                    <select class="custom-select" name="brands">
                                        <option value="0" selected>Choose brand</option>
                                        <?php 
                                            $getbrandsQuery = $dbs->query("SELECT * FROM product_brand");
                                            $getbrandsQuery->execute();
                                            while($brand = $getbrandsQuery->fetch(PDO::FETCH_ASSOC)){
                                                echo '<option value="'.$brand['br_id'].'">'.$brand['brand_name'].'</option>';
                                            }
                                            ?>
                                            ?>
                                    </select>
                                </div>
                            
                            </div>
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="add_brand" class="btn btn-success mb-2" value="Add brand">
                        <input type="submit" name="edit_brand" class="btn btn-primary mb-2" value="Edit brand">
                        <input type="submit" name="delete_brand" class="btn btn-danger mb-2" value="Delete brand">
                        <input type="reset" class="btn btn-info  mb-2" value="Clear Form">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    $dbs=null;
    ?>