<?php



?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INIAP</title>
  <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">

  <link rel="stylesheet" type="text/css" href="libs/bootstrap-5.0.2-dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="libs/toastr/toastr.css">
  <link rel="stylesheet" type="text/css" href="libs/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="libs/clockpicker/clockpicker.css">

  <script src="libs/jquery-3.7.0.min.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="libs/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
  <script src="libs/alertifyjs/alertify.js"></script>
  <script src="libs/select2/js/select2.js"></script>
  <script src="libs/toastr/toastr.js"></script>
  <script src="libs/daterangepicker/moment.min.js"></script>
  <script src="libs/daterangepicker/daterangepicker.js"></script>
  <script src="libs/clockpicker/clockpicker.js"></script>


</head>

<body>
  <?php require 'partials/header.php' ?>

  <section class="container" >
  <div class="abs-center">
          <div class="card" style="border-radius: 1rem;">
            <div  class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="assets/images/Logo.png" alt="login form" class="img-fluid"
                  style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">


                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">E.E. Tropical Pichilingue</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;"></h5>
                  <!-- Div de datos -->
                  <div class="form-outline mb-4">
                    <input type="text" id="username" name="txtusername" required placeholder="Usuario..."
                      class="form-control form-control-lg" />
                    <label class="form-label" for="txtusername"></label>
                  </div>
                  <div class="form-outline mb-4">
                    <input type="password" id="password" name="txtpassword" required placeholder="Contraseña..."
                      class="form-control form-control-lg" />
                    <label class="form-label" for="txtpassword"></label>
                  </div>
                  <div class="pt-1 mb-4">
                    <input type="button" id="login" class="btn btn-dark btn-lg btn-block" value="Iniciar Sesión" />
                  </div>
                  <?php

                  ?>
                </div>

          </div>
        </div>
        </div>
      </div>
  </section>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>


  <?php require 'partials/footer.php' ?>
</body>

</html>