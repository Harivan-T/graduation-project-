<?php 
    require_once("../connect.php");

    //add type
    if(isset($_POST['add_type'])){ 
        $product_type = $_POST['product_type'];
        if($product_type !==null && !empty($product_type)){
            $pro_query = @"INSERT INTO product_type (type) VALUES (:pro_type)";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":pro_type",$product_type); 
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product type has been added.</div>";
                }else{
                    echo "Error:";
                    print_r($dbs->errorInfo());
                }
        }else{
              echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,insert type name to add.</div>";
        }
    }

    //edit types
      if(isset($_POST['edit_type'])){
        $types = (int)$_POST['types'];
        $product_type = $_POST['product_type'];
         if($types !==0){
            $pro_query = @"UPDATE product_type SET type=:TP WHERE pro_t_id=:TID";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":TP",$product_type);
            $add_product_query->bindParam(":TID",$types);
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product type has been up to date.</div>";
                }else{
                    echo "Error: ";
                    print_r($dbs->errorInfo());
                }
         }else{
            echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select type to update.</div>";
         }
      }

    //delete types
      if(isset($_POST['delete_type'])){
        $types = (int)$_POST['types'];
        if($types !==0){
            $pro_query = @"DELETE FROM product_type  WHERE pro_t_id=:TID";
            $add_product_query = $dbs->prepare($pro_query);
            $add_product_query->bindParam(":TID",$types);
                if($add_product_query->execute()){
                    echo "<div class='alert alert-success m-2 col-md-12' role='alert'>product type has been deleted.</div>";
                }else{
                    echo "Error: ";
                    print_r($dbs->errorInfo());
                }
        }else{
            echo "<div class='alert alert-warning m-2 col-md-12' role='alert'>Please,select type to deleted.</div>";
        }
      }


    ?>
<div class="container bg-white">    
    <div class="col-lg-8">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/admin/?page=types" method="POST"  enctype='multipart/form-data'>
                    <div class="modal-header">
                        <h5 class="modal-title"> <i class="fa fa-store"></i> Types </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group col-md-6">
                                    <label for="product_type">Product Type</label>
                                    <input type="text" class="form-control" name="product_type" aria-describedby="productHelp">
                                </div>
                            
                                <div class="input-group mb-3 col-md-6">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Types</label>
                                    </div>
                                    <select class="custom-select" name="types">
                                        <option value="0" selected>Choose Type</option>
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
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="add_type" class="btn btn-success mb-2" value="Add Type">
                        <input type="submit" name="edit_type" class="btn btn-primary mb-2" value="Edit Type">
                        <input type="submit" name="delete_type" class="btn btn-danger mb-2" value="Delete Type">
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