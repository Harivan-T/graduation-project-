<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Save Skin - Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- CSS Libraries -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../lib/slick/slick.css" rel="stylesheet">
    <link href="../lib/slick/slick-theme.css" rel="stylesheet">
    <link href="../css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <script src="../js/apexcharts.js"></script>
    <script>
        
        function preview_images() {
            var total_file = document.getElementById("images").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#image_preview').append("<img class='img img-responsive m-1' height='80px' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
            }
        }

        function deleteImage(img){
            var id="img_id_"+img;
                if(confirm("Are you sure to delete image with id "+img)){
                    $.post("/actions.php",{
                        "delete_product_image":'ok',
                        "image_id":img,
                        },function(data, status){
                            if(status=="success"){
                                if(data=="ok");
                                $("#"+id).remove();
                            }else{
                                alert("try again");
                            }
                        });
                }
        }

        function setImageAsDefault(img,product){
            $.post("/actions.php",{
                "setImageAsDefault":'ok',
                "image_id":img,
                "product_id":product
                },function(data, status){
                    if(status=="success"){
                        $.post('/actions.php', {
                            "getProductImages": 'ok',
                            "product_id": product
                            }, function(data, status) {
                                if (status == "success") {
                                    $("#images_preview").html(data);
                                } else {
                                    alert("error");
                                }
                        });
                    }else{
                        alert("try again");
                    }
                });
        }
    </script>
</head>

<body>
    <!-- Bottom Bar Start -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo">
                        <a href="/admin">
                            <img src="../img/logo-admin.png" alt="Logo">
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Nav Bar Start -->
    <div class="nav  border-bottom border-primary">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="/admin/" class="nav-item nav-link"><i class="fa fa-home"></i> Home</a>
                        <a href="?page=categories" class="nav-item nav-link"><i class="fa fa-layer-group"></i> Categories</a>
                        <a href="?page=brands" class="nav-item nav-link"><i class="fa fa-tags"></i> Brands</a>
                        <a href="?page=types" class="nav-item nav-link"><i class="fa fa-store"></i> Types</a>
                        <a href="?page=add_product" class="nav-item nav-link"><i class="fa fa-plus-square"></i> Add Product</a>
                        <a href="?page=edit_product" class="nav-item nav-link"><i class="fa fa-pen"></i> Edit Product</a>
                        <a href="?page=customers" class="nav-item nav-link "><i class="fa fa-users"></i> Users</a>
                        <a href="?page=orders" class="nav-item nav-link"><i class="fa fa-shipping-fast"></i> Orders</a>
                        <a href="?page=reports" class="nav-item nav-link"><i class="fa fa-chart-bar"></i> Reports</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shield-alt"></i> Admin Account</a>
                            <div class="dropdown-menu">
                                <a href="/?logout=admin" class="dropdown-item"> <i class="fa fa-lock"></i> Logout</a>
                                <a href="?page=settings" class="dropdown-item"> <i class="fa fa-cog"></i> Settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Main -->
    <div class="header">
        <div class="container-sm">
            <div class="row">