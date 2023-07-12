<?php require_once '../auth/forwardAuthentication.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Relquio</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>
    <!-- end loader -->
    <!-- header -->
    <?php include 'nav.php' ?>
    <!-- end header inner -->
    <!-- end header -->
    <div class="ourwork">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Our Work</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our.jpg" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our1.jpg" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our.jpg" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our1.jpg" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our.jpg" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="our_box">
                        <figure><img src="images/our1.jpg" alt="#" /></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  footer -->
    <?php include 'footer.php' ?>
    <!-- end footer -->
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>

    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>
