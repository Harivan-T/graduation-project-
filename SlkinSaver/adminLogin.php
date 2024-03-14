<?php 
    ob_start();
    session_start();
    if(isset($_POST['login'])){
        require_once("connect.php");

        $email = $_POST['email'];
        $pass  = MD5($_POST['password']);

        $suerChecking = $dbs->prepare("SELECT * FROM admin WHERE email=:email AND password=:pass");
        $suerChecking->bindParam(':email',$email);
        $suerChecking->bindParam(':pass' ,$pass);
        $suerChecking->execute();
        $adminInfo = $suerChecking->fetch(PDO::FETCH_ASSOC);
        $name = $adminInfo['admin_name'];
        //check login 
        if($suerChecking->rowCount()>0){
            $_SESSION['admin'] = $email;   
            $_SESSION['name'] = $name;   
            header('location:/admin/');
        }else{
            header('location:/index.php?login=admin');
        }
    }
if(isset($_SESSION['admin'])){
   header("location:admin/index.php");
}else{

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SaveSkin - Admin Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
 
</head>

<body>
    <!-- Bottom Bar Start -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo">
                        <a href="../">
                            <img src="../img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Main -->
    <div class="header">
        <div class="container-sm">
            <div class="row">
                <!-- Login Start -->
                <div class="login">
                    <div class="container-fluid justify-content-center align-content-center">
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block">    
                                <img src="../img/skincare.jpg" alt="">
                            </div> -->
                            <div class="col-lg-10 col-md-10 center">
                                <h2><i class="fa fa-shield-alt"></i> Admin Login </h2>
                                <form action="/?login=admin" method="POST">
                                    <div class="login-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>E-mail</label>
                                                <input class="form-control" name="email" type="email" placeholder="E-mail">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Password</label>
                                                <input class="form-control"  name="password" type="password" placeholder="Password">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="hidden" name="login" value="ok">
                                                <button type="submit" name="login" class="btn btn-success"><i class="fa fa-shield-alt"></i> Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Login End -->
            </div>
        </div>
    </div>
    <!-- Main -->

    <br>
    <!-- Footer Bottom Start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>Copyright &copy; 2022  <a href="#"> Skinsaver co.</a>. All Rights Reserved</p>
                </div>
                <!-- <div class="col-md-6 template-by">
                    <p>By <a href="#">Student Name</a></p>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

    <!-- JavaScript Libraries -->
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <!-- <script src="../js/admin.js"></script> -->
</body>

</html>      

<?php
}

    ?>