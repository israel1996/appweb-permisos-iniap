<?php
include 'assets/php/sessionChecker.php';
include_once "assets/php/database.php";

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


  <section class="container-fluid" style="margin-top: 100px;">


    <!-- Modal PDF -->
    <div class="modal fade" id="modalPDFPermiss" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">PDF Permiso Generado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- iframe para cargar el PDF -->
            <iframe id="pdfFrame" src="" width="100%" height="500px"></iframe>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal para detalle de permisos pendientes -->
    <div class="modal fade" id="modalDetailPermiss" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailLabel">Detalles de Permiso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <input type="text" id="idPermiss" value="0" hidden>

                <label for="fullnameEmployee" class="form-label fw-bold">Empleado</label>
                <input type="text" name="fullnameEmployee" id="fullnameEmployee" class="form-control" readonly>

                <label for="nameReason" class="form-label fw-bold">Razón</label>
                <input type="text" name="nameReason" id="nameReason" class="form-control" readonly>


                <label for="issueDate" class="form-label fw-bold">Fecha de Emision</label>
                <input type="text" name="issueDate" id="issueDate" class="form-control" readonly>

                <label for="startDate" class="form-label fw-bold">Fecha de Inicio</label>
                <input type="text" name="startDate" id="startDate" class="form-control" readonly>

                <label for="endDate" class="form-label fw-bold">Fecha Final</label>
                <input type="text" name="endDate" id="endDate" class="form-control" readonly>

                <label for="observation" class="form-label fw-bold">Observación</label>
                <input type="text" name="observation" id="observation" class="form-control" readonly>

              </div>
              <div class="col-md-6">


                <label for="workingDays" class="form-label fw-bold">Dias laborales</label>
                <input type="text" name="workingDays" id="workingDays" class="form-control" readonly>

                <label for="weekendDays" class="form-label fw-bold">Fines de semana</label>
                <input type="text" name="weekendDays" id="weekendDays" class="form-control" readonly>

                <label for="total" class="form-label fw-bold">Total</label>
                <input type="text" name="total" id="total" class="form-control" readonly>

                <label class="form-label fw-bold" style="margin-top:12px">Seleccione una acción:</label>
                <div class="form-inline">

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chStatePermissAuthorize"
                      onclick="toggleCheckbox(this.id)" style="width: 20px; height: 20px; border: 2px solid #969696;">
                    <label class="form-check-label" for="chStatePermissAuthorize">Autorizar</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chStatePermissReject"
                      onclick="toggleCheckbox(this.id)" style="width: 20px; height: 20px; border: 2px solid #969696;">
                    <label class="form-check-label" for="chStatePermissReject">Rechazar/Anular</label>
                  </div>
                </div>

                <label for="observationDirector" class="form-label fw-bold">Respuesta</label>
                <textarea name="observationBoss" id="observationBoss" class="form-control" rows="4"></textarea>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success w-100" data-dismiss="modal"
              id="btnConfirmPermissDirector">Confirmar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-auto">
          <label for="dateDayPermisses" class="col-form-label fw-bold">Buscar:</label>
        </div>
        <div class="col-auto">
          <input type="text" name="campo_permisses" id="campo_permisses" class="form-control" placeholder="Escriba aquí...">
        </div>
        <div class="col-auto">
          <label for="statePermisseSearch" class="col-form-label fw-bold">Mostrar: </label>
        </div>
        <div class="col-auto">
          <select name="estado" id="statePermisseSearch" class="form-select">
            <option value="">Todos</option>
            <option value="P">Pendientes</option>
            <option value="A">Autorizados</option>
            <option value="V">Validados</option>
            <option value="R">Rechazados/Anulados</option>
          </select>
        </div>
      </div>
      <!-- Tabla Permisos -->
      <div class="row">
        <table class="table table-hover mt-1">
          <thead class="">
            <tr class="text-center">
              <th class="align-middle">ID Permiso</th>
              <th class="align-middle">Nombres y Apellidos</th>
              <th class="align-middle">Fecha de Emisión</th>
              <th class="align-middle">Estado</th>
              <th class="align-middle">Fecha de Inicio</th>
              <th class="align-middle">Fecha Final</th>
              <th class="align-middle">Dias Laborales</th>
              <th class="align-middle">Fines de Semana</th>
              <th class="align-middle">Total</th>
              <th class="align-middle">Validar</th>
              <th class="align-middle">Detalles</th>
            </tr>
          </thead>
          <tbody id="content_permisses">
          </tbody>
        </table>
      </div>

      <!-- Paginacion Periodos -->
      <div class="row">
        <div class="col-3">
          <label id="lbl-total-permisses"></label>
        </div>
        <!-- Número de Registros -->
        <div class="col-1" ;>
          <select name="num_registros_permisses" id="num_registros_permisses" class="form-select">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>
        </div>

        <div class="col-7" id="nav-paginacion-permisses"></div>
        <input type="hidden" id="pagina_permisses" value="1">
        <input type="hidden" id="orderCol_permisses" value="0">
        <input type="hidden" id="orderType_permisses" value="desc">

      </div>

    </div>


  </section>

  <?php require 'partials/footer.php' ?>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>

  <script>
    var titulo = "Validación de Permisos";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;
  </script>

  <script>

    function toggleCheckbox(clickedId) {
      const checkbox1 = document.getElementById("chStatePermissAuthorize");
      const checkbox2 = document.getElementById("chStatePermissReject");

      if (clickedId === "chStatePermissAuthorize" && checkbox1.checked) {
        checkbox2.checked = false;
      } else if (clickedId === "chStatePermissReject" && checkbox2.checked) {
        checkbox1.checked = false;
      }
    }
  </script>

  <script>

    getDataPermisses();

    document.getElementById("campo_permisses").addEventListener("keyup", function () {
      document.getElementById("pagina_permisses").value = 1;
      getDataPermisses();
    }, false)
    document.getElementById("statePermisseSearch").addEventListener("change", function () {
      document.getElementById("pagina_permisses").value = 1;
      getDataPermisses();
    }, false);
    document.getElementById("num_registros_permisses").addEventListener("change", function () {
      document.getElementById("pagina_permisses").value = 1;
      getDataPermisses();
    }, false);


    function getDataPermisses() {
      let input = document.getElementById("campo_permisses").value;
      let num_registros = document.getElementById("num_registros_permisses").value;
      let content = document.getElementById("content_permisses");
      let pagina = document.getElementById("pagina_permisses").value;
      let orderCol = document.getElementById("orderCol_permisses").value;
      let orderType = document.getElementById("orderType_permisses").value;
      let statePermiss = document.getElementById("statePermisseSearch").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tablePermissDirector.php";
      let formaData = new FormData();

      formaData.append('campo', input);
      formaData.append('registros', num_registros);
      formaData.append('pagina', pagina);
      formaData.append('orderCol', orderCol);
      formaData.append('orderType', orderType);
      formaData.append('statePermiss', statePermiss);


      fetch(url, {
        method: "POST",
        body: formaData
      }).then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById("lbl-total-permisses").innerHTML = 'Mostrando ' + data.totalRegistros +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion-permisses").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPagePermiss(pagina) {
      document.getElementById('pagina_permisses').value = pagina;
      getDataPermisses();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenarPermisses);
    }

    function ordenarPermisses(e) {
      let elemento = e.target;

      document.getElementById('orderCol_permisses').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType_permisses").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType_permisses").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getDataPermisses();

    }

  </script>



</body>

</html>