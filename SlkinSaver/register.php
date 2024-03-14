<?php 
    ob_start();
    session_start();


    //register
    if(isset($_POST['register'])){
        
            $email =  $_POST['email'];
            $fName =  $_POST['first_name'];
            $lName =  $_POST['last_name'];
            $phone =  $_POST['phone'];
            $password =  $_POST['password'];
            $repassword =  $_POST['repassword'];
            $passMd5 = MD5($password);

        if(!empty($email) && !empty($fName) && !empty($lName)  && !empty($phone) && !empty($password) && !empty($repassword) ){           
            if($password === $repassword){
                require_once("connect.php");
                $registerQuery = $dbs->prepare(@"INSERT INTO customer(first_name,last_name,email,phone,password) VALUES (:FN,:LN,:EM,:PN,:PW)");
                $registerQuery->bindParam(':FN',$fName);
                $registerQuery->bindParam(':LN',$lName);
                $registerQuery->bindParam(':EM',$email);
                $registerQuery->bindParam(':PN',$phone);
                $registerQuery->bindParam(':PW',$passMd5);
                if( $registerQuery->execute()){
                    //create session
                    $customer_id = $dbs->lastInsertId();
                    $_SESSION['customer'] = $email;   
                    $_SESSION['first_name'] = $fName;   
                    $_SESSION['customer_id'] = $customer_id; 
                    header('location:/'); 
                }else{
                    echo "Error in database";
                }
            }else{
                echo "Password miss match!";
            }
        }else{
            echo "Please,Fill all fields!";
        }

    
    
    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SaveSkin - Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
 
</head>

<body>
    <!-- Bottom Bar Start -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo">
                        <a href="/">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Login Start -->
    <div class="logins mt-0 mx-auto">
        <div class="container mt-0 pb-0 bg-white">
            <div class="row mb-0 mt-0 d-flex justify-content-center align-items-center">
                 <!-- register form -->
                <div class="col-lg-6">    
                    <h2>Register</h2>
                    <div class="register-form  border border-white">
                        <form action="?login=register" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" name="first_name" type="text" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name" type="text" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" name="email" type="text" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" name="phone" type="text" placeholder="Mobile No">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="password" type="password" placeholder="Password">
                                </div>
                                <div class="col-md-6">
                                    <label>Retype Password</label>
                                    <input class="form-control" name="repassword" type="password" placeholder="Password">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="submit" name="register" value="Register" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Login End -->
    <!-- Footer Bottom Start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>Copyright &copy;  2022 <a href="#"> Skinsaver co.</a>. All Rights Reserved</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

    <!-- JavaScript Libraries -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

  
</body>

</html>                