<?php
    ob_start();
    session_start();
    include_once("connect.php");
    /*  *************************************
        * ***********
        * *************  visitor actions area permissioned  *************
        * ***********
        * ***********************************
     */

    //search ...
    if(isset($_POST['search'])){
        $key = $_POST['key'];
        $default_image = 1;
        if(!empty($key) && strlen($key)>2){
                $Query = "SELECT products.*,images.* 
                            FROM products
                                LEFT JOIN images 
                                    ON  images.img_product_id = products.pro_id && images.img_default=:I
                                WHERE pro_name LIKE :K;";
                $Key = "%".$key."%";
                $productQuery = $dbs->prepare($Query);
                $productQuery->bindParam('I',$default_image);
                $productQuery->bindParam('K',$Key);
                $productQuery->execute();
            if( $productQuery->rowCount()>0){
                while($product = $productQuery->fetch(PDO::FETCH_ASSOC)){
                    echo '<div class="list-group-item  p-2">
                            <div class="media">
                                <img src="products/'.$product['img_src'].'" alt="product name" class="align-self-start img-thumbnail img-responsive" style="width:50px;">
                                <div class="media-body border-1 pl-2">
                                    <a href="/?page=product&id='.$product['pro_id'].'" aria-current="true"><small>'.$product['pro_name'].'</small></a></div>
                                </div>
                            </div>';
                }
            }
        }
       
    }

    //
    
    /*  *************************************
        * ***********
        * *************  admin actions area permissioned  *************
        * ***********
        * ***********************************
     */
    if(isset($_SESSION['admin'])){

        //delete product image from images table.
        if(isset($_POST['delete_product_image'])){
            $id =$_POST['image_id'];
            $delete_product_image_Query = $dbs->query("DELETE FROM images WHERE img_id=$id");
            if($delete_product_image_Query->execute()){
                echo "ok";
            }else{
                echo "error";
            }
        }

        //delete_category_from_product
        if(isset($_POST['delete_category_from_product'])){
            $cid =$_POST['pro_cat_id'];
            $pid =$_POST['pro_id'];
            //pro_cat_id
            $delete_product_cat_Query = $dbs->query("DELETE FROM product_categories WHERE product_cat_id=$cid AND product_id=$pid;");
            if($delete_product_cat_Query->execute()){
                echo "ok";
            }else{
                echo "error";
            }
        }

        //power system on or off
        if(isset($_POST['powerStystem'])){
            sleep(2);
            $action =$_POST['action'];
            $Power_System_Query = $dbs->query("UPDATE  settings SET setting_value=$action  WHERE setting_key='operating';");
            if($Power_System_Query->execute()){
                echo "ok";
            }else{
                echo "error";
            }
        }

        //order actions
        if(isset($_POST['orderAction'])){
                $ord_id = $_POST['order'];
                $ord_action = $_POST['action'];

                $orderActionQuery = $dbs->prepare("UPDATE orders SET ord_status=:OS WHERE ord_id=:OID;");
                $orderActionQuery->bindParam(':OS',$ord_action);
                $orderActionQuery->bindParam(':OID',$ord_id);
                if($orderActionQuery->execute()){
                    //update quantity product ordered
                    if($ord_action=="canceled"){
                            //get last order id
                        $getProducts = $dbs->query("SELECT order_list.*,products.*
                                                    FROM order_list 
                                                        LEFT JOIN products
                                                            ON products.pro_id = order_list.ord_list_product
                                                    WHERE order_list.ord_list_number=$ord_id");
                        $getProducts->execute();
                            //open product in carts
                        while($product = $getProducts->fetch(PDO::FETCH_ASSOC)){
                              $product_id  = $product['ord_list_product'];
                              $product_qty = $product['ord_list_qty'];
                              $amount = $product['pro_amount'];
                            //update product amount
                              $amoundProduct = $amount+$product_qty;
                              $decreaseProduct = $dbs->query("UPDATE products SET pro_amount=$amoundProduct WHERE pro_id=$product_id;");
                              $decreaseProduct->execute();
                        }

                    }
                    echo "ok";
                }else{
                    echo "error";
                }

        }

        //set targers
        if(isset($_POST['setTarget'])){
            $target = $_POST['setTarget'];
            $value = $_POST['value'];
            
            $setTargetQuery = $dbs->prepare("UPDATE settings SET setting_value=:SV WHERE setting_key=:SK");
            $setTargetQuery->bindParam(':SV',$value);
            $setTargetQuery->bindParam(':SK',$target);
            if($setTargetQuery->execute()){
                echo "Target $target has been set to value $value";
            }else{
                echo "error";
            }


        }

        //get product images
        if(isset($_POST['getProductImages'])){
            $product_id = $_POST['product_id'];
            $getProductImages = $dbs->query("SELECT * FROM images WHERE img_product_id=$product_id");
            $getProductImages->execute();
            while($image = $getProductImages->fetch(PDO::FETCH_ASSOC)){
                $isDefault = $image['img_default']=="1" ? " border border-primary ":"   ";
                echo '<div id="img_id_'.$image['img_id'].'" class="'.$isDefault.'" style="margin:2px;padding:2px;float:left;">                                        
                            <img class="img img-responsive m-1" src="../products/'.$image['img_src'].'" alt="image" height="80px">
                            <div style="text-align:center;">';
                    if($image['img_default']!="1"){
                        echo '  <button onclick="setImageAsDefault('.$image['img_id'].",".$image['img_product_id'].');" id="product_image_id_'.$image['img_product_id'].'" type="button" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i>
                                </button>';
                    }
                echo '                
                            </div>
                        </div>';
            }

        }

        //set image as default
        if(isset($_POST['setImageAsDefault'])){
            $img_id = $_POST['image_id'];
            $product_id =$_POST['product_id'];
            //set all images default to 0
            $updateDefaults = $dbs->query("UPDATE images SET img_default=0 WHERE img_product_id=$product_id");
            $updateDefaults->execute();
            //set selected image to default 1
            $updateDefaults = $dbs->query("UPDATE images SET img_default=1 WHERE img_id=$img_id");
            $updateDefaults->execute();
        }

    }
    /*  *************************************
        * ***********
        * *************  customer actions area permissioned  *************
        * ***********
        * ***********************************
     */
        //add item to cart
        if(isset($_POST['add_to'])){
            if(isset($_SESSION['customer'])){

            $table = $_POST['action']==="cart" ? 'carts' : 'wishlist';        
            $proID = $_POST['product_id'];            
            $proQty = (isset($_POST['product_qty']) && $_POST['product_qty']!="NaN") ? $_POST['product_qty'] : 1;
            $custID = $_SESSION['customer_id'] ?? 0;
            $addProductToCart = $dbs->prepare("INSERT INTO $table (custID,proID,proQty)VALUES(:CID,:PID,:PQTY)");
            $addProductToCart->bindParam(':CID',$custID);
            $addProductToCart->bindParam(':PID',$proID);
            $addProductToCart->bindParam(':PQTY',$proQty);
            if($addProductToCart->execute()){
                if($table=="carts"){
                    echo "Product has been added to cart";
                }else{
                    echo "Product has been added to wishlist";
                }
            }else{
                echo "error adding product to cart";
            }
            }else{
                echo "Please,login or register!";
            }
        }

        //remove item from cart
        if(isset($_POST['remove_from'])){
            if(isset($_SESSION['customer'])){
                $CID = $_POST['product_id'];
                $table = ($_POST['action']==="cart") ? " carts " : " wishlist ";                             
                $CUID = $_SESSION['customer_id'] ?? 0;
                $addProductToCart = $dbs->prepare("DELETE FROM $table WHERE cartID=:CID AND custID=:CUID");
                $addProductToCart->bindParam(':CID',$CID);
                $addProductToCart->bindParam(':CUID',$CUID);
                if($addProductToCart->execute()){
                    echo "ok";
                }else{
                    echo "error removing product";
                }
            }else{
                echo "Please,login or register!";
            }
        }

        //change item quantity
        if(isset($_POST['change_quantity'])){
            if(isset($_SESSION['customer'])){
                $cartID = $_POST['product_id'];
                if($_POST['action']=="add"){
                    $sql = "UPDATE  carts SET proQty=proQty+1 WHERE cartID=:CID";
                }else{
                    $sql = "UPDATE  carts SET proQty=proQty-1 WHERE cartID=:CID AND proQty>1";
                }
                $updateQuantity = $dbs->prepare($sql);
                $updateQuantity->bindParam(':CID',$cartID);
                if($updateQuantity->execute()){
                    echo "ok";
                }else{
                    echo "Error in sql";
                }
            }else{
                echo "Please,login or register!";
            }
        }

        //empty cart
        if(isset($_POST['emptyCart'])){
            if(isset($_SESSION['customer'])){
                $CUID = $_SESSION['customer_id'] ?? 0;
                $addProductToCart = $dbs->prepare("DELETE FROM carts WHERE custID=:CUID");    
                $addProductToCart->bindParam(':CUID',$CUID);
                if($addProductToCart->execute()){
                    echo "ok";
                }else{
                    echo "error empting cart!";
                }
            }else{
                echo "Please,login or register!";
            }
        }

        //order cart
        if(isset($_POST['orderCart'])){
            if(isset($_SESSION['customer'])){
                $CUID = $_SESSION['customer_id'] ?? 0;
                $payment = $_POST['payment'];
                $address = $_POST['address'];
                $status = "ordered";
                    $create_order =$dbs->prepare("INSERT INTO orders(ord_customer,ord_shipping,ord_payment,ord_status)VALUES(:OC,:OA,:OP,:OS)");
                    $create_order->bindParam(':OC',$CUID);
                    $create_order->bindParam(':OA',$address);
                    $create_order->bindParam(':OP',$payment);
                    $create_order->bindParam(':OS',$status);

                    if($create_order->execute()){
                            //get last order id
                        $ord_id = $dbs->lastInsertId();
                        $getProducts = $dbs->query("SELECT carts.*,products.*
                                                    FROM carts 
                                                        LEFT JOIN products
                                                            ON products.pro_id = carts.proID
                                                    WHERE carts.custID=$CUID");
                        $getProducts->execute();
                            //open product in carts
                        while($product = $getProducts->fetch(PDO::FETCH_ASSOC)){
                            $product_id = $product['proID'];
                            $product_price = $product['price_sell'];
                            $product_qty = $product['proQty'];
                            //check quantity
                            $checkQtyProducts = $dbs->query("SELECT pro_amount FROM products WHERE pro_id=$product_id");
                            $checkQtyProducts->execute();
                            $checkQtyProducts = $checkQtyProducts->fetch(PDO::FETCH_ASSOC);
                            $amount = $checkQtyProducts['pro_amount'];

                            //record products ordered
                            $insertOrderList = $dbs->prepare(@"
                                        INSERT INTO order_list(ord_list_number,ord_list_product,ord_list_qty,ord_list_product_price)
                                        VALUES (:OLN,:OPN,:OQ,:OPP) ");
                            $insertOrderList->bindParam(':OLN',$ord_id);
                            $insertOrderList->bindParam(':OPN',$product_id);
                            $insertOrderList->bindParam(':OQ',$product_qty);
                            $insertOrderList->bindParam(':OPP',$product_price);
                            $insertOrderList->execute();
                            //decrease product amount
                            $amoundProduct = $amount- $product_qty;
                            $decreaseProduct = $dbs->query("UPDATE products SET pro_amount=$amoundProduct WHERE pro_id=$product_id;");
                            $decreaseProduct->execute();
                        }
                            //delete all items in cart
                            $deleteCart = $dbs->query("DELETE  FROM carts WHERE custID=$CUID");
                            if($deleteCart->execute()){
                                echo "Order has been done.Please,Wait..";
                            }
                    }
              
            }else{
                echo "Please,login or register!";
            }
        }

        //buy now
        if(isset($_POST['buynow'])){
            if(isset($_SESSION['customer'])){
                $CUID = $_SESSION['customer_id'] ?? 0;
                $payment = $_POST['payment'];
                $address = $_POST['address'];
                $product_id = $_POST['product'];
                $quantity = $_POST['qty'];
                $status = "ordered";
                //check quantity
                $checkQtyProducts = $dbs->query("SELECT pro_amount,price_sell FROM products WHERE pro_id=$product_id");
                $checkQtyProducts->execute();
                   $checkQtyProducts = $checkQtyProducts->fetch(PDO::FETCH_ASSOC);
                   $amount = $checkQtyProducts['pro_amount'];
                   $product_price = $checkQtyProducts['price_sell'];

                if($amount-$quantity>0){
                    
                    $create_order =$dbs->prepare("INSERT INTO orders(ord_customer,ord_shipping,ord_payment,ord_status)VALUES(:OC,:OA,:OP,:OS)");
                    $create_order->bindParam(':OC',$CUID);
                    $create_order->bindParam(':OA',$address);
                    $create_order->bindParam(':OP',$payment);
                    $create_order->bindParam(':OS',$status);
                    $create_order->execute();
                        //get last order id
                        $ord_id = $dbs->lastInsertId();
                        //record products ordered
                        $insertOrderList = $dbs->prepare(@"
                                    INSERT INTO order_list(ord_list_number,ord_list_product,ord_list_qty,ord_list_product_price)
                                    VALUES (:OLN,:OPN,:OQ,:OPP) ");
                        $insertOrderList->bindParam(':OLN',$ord_id);
                        $insertOrderList->bindParam(':OPN',$product_id);
                        $insertOrderList->bindParam(':OQ',$quantity);
                        $insertOrderList->bindParam(':OPP',$product_price);
                        $insertOrderList->execute();

                        //decrease product amount
                        $amountUpdate =$amount-$quantity;
                        $decreaseProduct = $dbs->prepare("UPDATE products SET pro_amount=:CQY  WHERE pro_id=:PID");
                        $decreaseProduct->bindParam(':CQY',$amountUpdate);
                        $decreaseProduct->bindParam(':PID',$product_id);
                        $decreaseProduct->execute();
                        echo "Order has been placed,thanks";
                     
                }else{
                    echo "You can't order $quantity of this product, there is $amount of it!";
                }   
 
            }else{
                echo "Please,login or register!";
            }
        }
 


    ?>