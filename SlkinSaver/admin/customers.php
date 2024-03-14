<?php 
    require_once("header.php");
    require_once("../connect.php");

       //register
    if(isset($_POST['register'])){
            $email =  $_POST['email'];
            $fName =  $_POST['first_name'];
            $password =  $_POST['password'];
            $passMd5 = MD5($password);
                if(!empty($email) && !empty($fName)  && !empty($password) ){           
                    $registerQuery = $dbs->prepare(@"INSERT INTO admin(admin_name,email,password) VALUES (:AN,:EM,:PW)");
                    $registerQuery->bindParam(':AN',$fName);
                    $registerQuery->bindParam(':EM',$email);
                    $registerQuery->bindParam(':PW',$passMd5);
                    if( $registerQuery->execute()){
                            header('location:/admin/?page=customer');
                    }else{
                        echo "Error in database";
                    }
                }else{
                    echo "Please,Fill all fields!";
                }
            
    }
    ?>
<div class="container bg-white">
    <div class="row">
        <div class="col-lg-8">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="?page=customers" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Register new admin </h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Admin Name</label>
                                    <input class="form-control" name="first_name" type="text" placeholder="Admin Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" name="email" type="text" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="password" type="password" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="register" value="Register" class="btn btn-success">
                        </div>
                </form> 
                </div>
            </div>
        </div> 
        <?php 
            $membersQuery = $dbs->query("SELECT * FROM customer");
            $membersQuery->execute();
            $customers = $membersQuery->rowCount();
            ?>
        <div class="col-lg-4">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="?page=customers" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title"> Customers </h5>
                            <span class="badge badge-primary badge-pill"><?php echo $customers;?></span>
                        </div>
                        <div class="modal-body" style="height:400px;overflow:scroll;">
                            <ul class="list-group">
                                <?php 
                                    while($customer = $membersQuery->fetch(PDO::FETCH_ASSOC)){ ?>
                                        <li class="list-group-item"> 
                                            <h5><?php echo $customer['first_name'] ." ".$customer['last_name'];?></h5>
                                            <?php echo $customer['email'];?>
                                        
                                        </li>
                                        <?php 
                                    }
                                        ?>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php 
    require_once("footer.php");
    ?>