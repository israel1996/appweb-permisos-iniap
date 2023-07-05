<?php
include 'assets/php/sessionChecker.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SISTEMA DE PERMISOS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">

  <link rel="stylesheet" type="text/css" href="libs/bootstrap-5.0.2-dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="libs/select2/css/select2.css">
  <link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="libs/toastr/toastr.css">
  <link rel="stylesheet" type="text/css" href="libs/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="libs/clockpicker/clockpicker.css">

  <script src="libs/jquery-3.7.0.min.js"></script>
  <script src="libs/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
  <script src="libs/select2/js/select2.js"></script>
  <script src="libs/alertifyjs/alertify.js"></script>
  <script src="libs/toastr/toastr.js"></script>
  <script src="libs/daterangepicker/moment.min.js"></script>
  <script src="libs/daterangepicker/daterangepicker.js"></script>
  <script src="libs/clockpicker/clockpicker.js"></script>
</head>

<body>
  <?php require 'partials/header.php' ?>

  <section class="container" style="margin-top:100px;">
    <nav>
      <div class="nav nav-pills nav-justified" id="nav-tab" roles="tablist">
        <button class="nav-link active custom" id="nav-mainLogo-tab" data-bs-toggle="tab" data-bs-target="#mainLogo"
          type="button" role="tab" aria-controls="nav-mainLogo" aria-selected="true">Logo Principal</button>

        <button class="nav-link custom" id="nav-certificateLogos-tab" data-bs-toggle="tab"
          data-bs-target="#certificateLogos" type="button" role="tab" aria-controls="nav-certificateLogos"
          aria-selected="true">Logos de Certificado</button>
    </nav>
    <div class="tab-content" id="tab-content">
      <div id="mainLogo" class="tab-pane fade show active" style="margin-top:50px">

        <div class="row">

          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="row">
              <div class="col">
                <label for="file" class="form-label fw-bold">Seleccione la Imagen/Logo</label>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <input type="file" class="form-control" name="file" id="fileMainLogo" accept="image/png">
              </div>
            </div>

            <div class="row" style="margin-top:10px">
              <div class="col">
                <button type="button" class="btn btn-dark w-100" id="btnUploadMainLogo">Subir Logo</button>
              </div>
            </div>
          </div>

          <div class="col-sm-1"></div>

          <div class="col-sm-5">
            <img src="assets/images/Logo.png" alt="No se encuentra ninguna imagen" height="200">
          </div>
          

        </div>

      </div>

      <div id="certificateLogos" class="tab-pane fade" style="margin-top:50px">

        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="container">
              <div class="row">
                <div class="col">
                  <label for="file" class="form-label fw-bold">Seleccione la Imagen/Logo (Encabezado)</label>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <input type="file" class="form-control" name="file" id="fileLogoHeader" accept="image/png">
                </div>
              </div>
              <div class="row" style="margin-top:10px">
                <div class="col">
                  <button type="button" class="btn btn-dark w-100" id="btnUploadLogoHeader">Subir Encabezado</button>
                </div>
              </div>
              <div class="row" style="margin-top:50px">
                <img src="assets/images/Logo_header.png" alt="No se encuentra ninguna imagen" height="200">
              </div>
            </div>
          </div>

          <div class="col-sm-5">
            <div class="container">
              <div class="row">
                <div class="col">
                  <label for="file" class="form-label fw-bold">Seleccione la Imagen/Logo (Pie de página)</label>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <input type="file" class="form-control" name="file" id="fileLogoFooter" accept="image/png">
                </div>
              </div>
              <div class="row" style="margin-top:10px">
                <div class="col">
                  <button type="button" class="btn btn-dark w-100" id="btnUploadLogoFooter">Subir Pie de página</button>
                </div>
              </div>
              <div class="row" style="margin-top:50px">
                <img src="assets/images/Logo_footer.png" alt="No se encuentra ninguna imagen" height="200">
              </div>
            </div>
          </div>
          <div class="col-sm-1"></div>
        </div>

      </div>
    </div>




  </section>

  <?php require 'partials/footer.php' ?>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>
  <script src="assets/js/validations.js"></script>

  <script>
    var titulo = "Subir Logo";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;
  </script>


</body>

</html>