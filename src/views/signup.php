<?php require_once '../auth/forwardAuthentication.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Sign up</title>
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
                        Inventory Empire Initiation
                    </div>
                    <div class="desc">
                        Embark on a transformative inventory management journey.
                    </div>
                </div>
                <div class="ilustration bill position-absolute">
                    <img src="../static/images/bill.png" alt="bill" />
                </div>
                <div class="patterns pattern1"></div>
                <div class="patterns pattern2"></div>
                <div class="shape col1-circle"></div>
            </div>
            <div class="col d-flex flex-column align-items-center py-5 gap-3">
                <h5 class="dark-primary">Create company account</h5>
                <form action="../controller/signup.php" method="POST" class="d-flex flex-column gap-4 mt-4">
                    <?php
          if (isset($_GET['message']) && isset($_GET['type'])) { ?>
                    <div class="alert alert-<?= $_GET['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_GET['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <div class="form-group d-flex flex-column gap-2">
                        <label for="name">Company Name : </label>
                        <input type="text" name="name" id="name" class="px-2 raduis5"
                            placeholder="enter your business name"
                            value="<?= (isset($_SESSION['form_data']['name'])) ? $_SESSION['form_data']['name'] : '' ?>" />
                    </div>
                    <div class="form-group d-flex flex-column gap-2">
                        <label for="username">User name : </label>
                        <input type="text" name="username" id="username" class="px-2 raduis5"
                            placeholder="enter your username"
                            value="<?= (isset($_SESSION['form_data']['username'])) ? $_SESSION['form_data']['username'] : '' ?>" />
                    </div>
                    <div class="form-group d-flex flex-column gap-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="px-2 raduis5"
                            placeholder="enter your email address"
                            value="<?= (isset($_SESSION['form_data']['email'])) ? $_SESSION['form_data']['email'] : '' ?>" />
                    </div>
                    <div class="form-group d-flex flex-column gap-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="px-2 raduis5" placeholder="password"
                            value="<?= (isset($_SESSION['form_data']['password'])) ? $_SESSION['form_data']['password'] : '' ?>" />
                    </div>

                    <div class="form-group">
                        <button class="btn raduis5 text-center">Sign up</button>
                    </div>

                    <div class="form-group">
                        <div class="reset-pass">
                            Already have an account ? <a href="./login.php">login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="shape circle"></div>
    <div class="shape circle-border"></div>
</body>

</html>
