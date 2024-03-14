<?php 
    ob_start();
    session_start();
    //login
    if(isset($_POST['login'])){
        require_once("connect.php");

        $email = $_POST['email'];
        $pass  = MD5($_POST['password']);
     
        $suerChecking = $dbs->prepare("SELECT * FROM customer WHERE email=:email AND password=:pass");
        $suerChecking->bindParam(':email',$email);
        $suerChecking->bindParam(':pass' ,$pass);
        $suerChecking->execute();
        //check login 
        if($suerChecking->rowCount()>0){
            //get customer info
            $customerInfo = $suerChecking->fetch(PDO::FETCH_ASSOC);
            $name = $customerInfo['first_name'];
            $customer_id  = $customerInfo['cust_id'];
            //create session
            $_SESSION['customer'] = $email;   
            $_SESSION['first_name'] = $name;   
            $_SESSION['customer_id'] = $customer_id;   
            header('location:/index.php');
        }else{
            header('location:/index.php?login=customer');
        }
    }
 

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SaveSkin - Login</title>
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
                <!-- login form -->
                <div class="col-lg-5">
                    <h2>Login</h2>
                    <div class="login-form pr-2 ">
                        <form action="?login=customer" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control"  name="email" type="text" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="password" type="password" placeholder="Password">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="submit" name="login" value="Login" class="btn btn-primary">
                                    <a class="btn btn-success btn-sm" href="/?login=register"> Don't have an account !?</a>
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