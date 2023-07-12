<?php
require_once '../auth/forwardAuthentication.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Login</title>
    <link rel="stylesheet" type="text/css" href="../controller/pallete.css.php">
    <?php include 'links.php' ?>

    <!-- link the css styles -->
    <link rel="stylesheet" href="../static/css/login.css" />

    <!-- link the js code -->
    <script defer src="../static/js/login.js"></script>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="row row-cols-2 w-75">
            <div class="col d-flex flex-column align-items-center justify-content-center py-5 gap-3 position-relative">
                <div class="row w-75 d-flex flex-column gap-1">
                    <div class="title display-4 fw-bolder">
                        Whenever You need Help
                    </div>
                    <div class="desc">
                        We're here for you, Don't worry.
                    </div>
                </div>
                <div class="ilustration bill position-absolute">
                    <img src="../static/images/bill.png" alt="bill" />
                </div>
                <div class="patterns pattern1"></div>
                <div class="patterns pattern2"></div>
                <div class="shape col1-circle"></div>
            </div>
            <div class="col d-flex flex-column align-items-center py-5 gap-5 h-100">
                <div class="logo mt-2">
                    <img src="../interface/images/logo.png" alt="logo" />
                </div>
                <h5 class="dark-primary">Account Password reseat!</h5>
                <form action="../controller/email1.php" method="POST" class="d-flex flex-column gap-4">
                    <?php
                    if (isset($_GET['message']) && isset($_GET['type'])) { ?>
                    <div class="alert alert-<?= $_GET['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_GET['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <div class="form-group d-flex flex-column gap-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="px-2 raduis5"
                            placeholder="enter your email address" />
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <div class="check-group d-flex align-items-center gap-2">

                        </div>
                        <div class="reset-pass">

                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn raduis5 text-center">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="shape circle"></div>
    <div class="shape circle-border"></div>
</body>

</html>
