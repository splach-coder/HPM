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
    <title>Reliquio</title>
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
    <!-- banner -->
    <div id="myCarousel" class="carousel slide banner_main" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
            <li data-target="#myCarousel" data-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="first-slide" src="images/banner.jpg" alt="First slide">
                <div class="container">
                    <div class="carousel-caption relative">
                        <h1> <span> </span>Inventory Managment</h1>
                        <a href="#contact">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="second-slide" src="images/banner.jpg" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption relative">
                        <h1> <span> </span>Inventory Managment</h1>
                        <a href="#contact">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="images/banner.jpg" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption relative">
                        <h1> <span> </span>Inventory Managment</h1>
                        <a href="#contact">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="images/banner.jpg" alt="four slide">
                <div class="container">
                    <div class="carousel-caption relative">
                        <h1> <span> </span>Inventory Managment</h1>
                        <a href="#contact">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="images/banner.jpg" alt="five slide">
                <div class="container">
                    <div class="carousel-caption relative">
                        <h1> <span> </span>Inventory Managment</h1>
                        <a href="#contact">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- end banner -->
    <!-- about -->
    <div id="about" class="about">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-7">
                    <div class="titlepage">
                        <h2>Purchases Management</h2>
                        <span></span>
                        <p>At our inventory management system, we've revolutionized the way you handle purchases. We
                            understand the importance of efficient procurement and the impact it has on your business.
                            That's why we've developed a purchases management feature that will leave you amazed.

                            With our system, you'll experience a seamless purchasing process that takes away the stress
                            and ensures accuracy every step of the way. From creating purchase orders to tracking
                            deliveries, we've got you covered. Say goodbye to manual paperwork and endless follow-ups.
                            Our intuitive interface empowers you to manage purchases effortlessly.</p>
                        <a class="read_more">Read More <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="about_img">
                        <figure><img src="images/about_img.png" alt="#" /></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->
    <!-- mobile -->
    <div id="mobile" class="mobile">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-5">
                    <div class="mobile_img">
                        <figure><img src="images/mobile.png" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="titlepage">
                        <h2>Sales Management</h2>
                        <span></span>
                        <p>We understand that managing sales is the lifeblood of any business, and that's why our
                            inventory management system takes sales management to a whole new level. Brace yourself for
                            a sales experience like no other.

                            From generating quotes to processing orders and tracking shipments, our sales management
                            feature simplifies the entire process. The user-friendly interface and streamlined workflows
                            ensure that you can focus on what truly matters – growing your business.</p>
                        <a class="read_more">Read More <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end mobile -->
    <!-- clients -->
    <div class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="titlepage">
                        <h2>What is Say clients</h2>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clients_box">
                        <p>I just have to say, our experience with your inventory management website has been absolutely
                            fantastic! From the moment we started using it, we knew we had found a game-changer. The
                            level of care and attention you give to your clients is truly remarkable.

                            Not only do you listen to our needs, but you go above and beyond to ensure that we have
                            everything we require for smooth inventory management. Your team is always there for us,
                            ready to address any concerns or questions we may have. The support we receive is
                            unparalleled!

                            The user-friendly interface and intuitive features make managing our inventory a breeze.
                            We've seen a significant improvement in our efficiency and accuracy since implementing your
                            system. It's like you've tailored it specifically for our business.</p>
                    </div>
                    <div class="jonu">
                        <img src="images/cross_img.png" alt="#" />
                        <h3>Jone due</h3>
                        <strong>(sure there isn't)</strong>
                        <a class="read_more" href="#">Get A Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end clients -->
    <!--  contact -->
    <div id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Request A call back</h2>
                    </div>
                </div>
                <div class="col-md-6 offset-md-3">
                    <form id="request" class="main_form">
                        <div class="row">
                            <div class="col-md-12 ">
                                <input class="contactus" placeholder="Full Name" type="type" name="Full Name">
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Phone Number" type="type" name="Phone Number">
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Email" type="type" name="Email">
                            </div>
                            <div class="col-md-12">
                                <textarea class="contactus" placeholder="Message" type="type"
                                    Message="Name">Message </textarea>
                            </div>
                            <div class="col-sm-12">
                                <button class="send_btn">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact -->
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
