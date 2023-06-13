<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HPM | Login</title>

  <?php include 'links.php' ?>

  <!-- link the css styles -->
  <link rel="stylesheet" href="../static/css/login.css" />
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
        <div class="logo">
          <img src="../static/images/logo.jpeg" alt="logo" />
        </div>
        <h5 class="dark-primary">Hello ! Welcome back</h5>
        <form action="#" class="d-flex flex-column gap-4">
          <div class="form-group d-flex flex-column gap-2">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="px-2 raduis5" placeholder="enter your email address" />
          </div>
          <div class="form-group d-flex flex-column gap-2">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="px-2 raduis5" placeholder="password" />
          </div>
          <div class="form-group d-flex justify-content-between">
            <div class="check-group d-flex align-items-center gap-2">
              <input type="checkbox" name="remember_me" id="rememberme" class="raduis5 p-2" />
              <label for="rememberme">Remember me</label>
            </div>
            <div class="reset-pass">
              <a href="#">Reset password</a>
            </div>
          </div>
          <div class="form-group">
            <button class="btn raduis5 text-center">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="shape circle"></div>
  <div class="shape circle-border"></div>
</body>

</html>