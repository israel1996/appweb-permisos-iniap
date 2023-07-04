<?php
include 'assets/php/sessionChecker.php';
include_once "assets/php/database.php";

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

  <section class="container" style="margin-top: 100px;">


    <div class="container">

      <input type="hidden" id="idPermissBack" value="0">
      <input type="hidden" id="idEmployeeSelectedPermissBack" value="0">

      <div class="row g-4">
        <div class="col-auto">
          <div id="slotSearchEmployeePermissBack"></div>
        </div>

        <div class="col-2"></div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <label for="num_permissBack" class="col-form-label fw-bold">Buscar: </label>
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <input type="text" name="campo" id="campo_permissBack" class="form-control" placeholder="Escriba aquí...">
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <label for="num_permissBack" class="col-form-label fw-bold">Mostrar: </label>
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <select name="num_permissBack" id="num_registros_permissBack" class="form-select">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>
        </div>
      </div>

      <div class="row">
        <!-- Tabla Periodos -->
        <table class="table table-hover mt-4">
          <thead class="">
            <tr class="text-center">
              <th class="align-middle">ID</th>
              <th class="align-middle">Nombres y Apellidos</th>
              <th class="align-middle">Fecha de Emisión</th>
              <th class="align-middle">Fecha de Activación</th>
              <th class="align-middle">Estado</th>
              <th class="align-middle">Editar</th>
            </tr>
          </thead>
          <tbody id="content_permissBack">
          </tbody>
        </table>

        <!-- Paginacion Periodos -->
        <div class="row">
          <div class="col-5">
            <label id="lbl-total-permissBack"></label>
          </div>
          <div class="col-7" id="nav-paginacion-permissBack"></div>
          <input type="hidden" id="pagina_permissBack" value="1">
          <input type="hidden" id="orderCol_permissBack" value="0">
          <input type="hidden" id="orderType_permissBack" value="desc">
        </div>

      </div>
    </div>

    <!-- Modal para habilitar permisos atrasados -->
    <div class="modal fade" id="modalPermissBack" tabindex="-1" aria-labelledby="modalPermissBackLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPermissBackLabel">Habilitar Fecha</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="cedulaEmployeePermissBack" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeePermissBack" class="form-control" disabled>

                <label for="nameEmployeePermissBack" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeePermissBack" class="form-control" disabled>

                <label for="lastNameEmployeePermissBack" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeePermissBack" class="form-control" disabled>

              </div>

              <div class="col-md-6">

                <label for="departamentEmployeePermissBack" class="form-label fw-bold">Departamento</label>
                <input type="text" id="departamentEmployeePermissBack" class="form-control" disabled>

                <label for="datePermissBack" class="form-label  fw-bold">Fecha</label>
                <input type="text" name="datesingleAdmin" class="form-control" id="datePermissBack">
                <label for="motivo" class="form-label  fw-bold">Estado</label>
                <select name="selectStatePermissBack" id="selectStatePermissBack" class="form-select">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnEmployeePermissBack" class="btn btn-dark w-100">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para editar permisos atrasados -->
    <div class="modal fade" id="modalPermissBacku" tabindex="-1" aria-labelledby="modalPermissBackuLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPermissBackuLabel">Habilitar Fecha</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">

                <input type="text" id="idPermissBack" value="0" hidden>

                <label for="cedulaEmployeePermissBacku" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeePermissBacku" class="form-control" disabled>

                <label for="nameEmployeePermissBacku" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeePermissBacku" class="form-control" disabled>

                <label for="lastNameEmployeePermissBacku" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeePermissBacku" class="form-control" disabled>

              </div>

              <div class="col-md-6">

                <label for="departamentEmployeePermissBacku" class="form-label fw-bold">Departamento</label>
                <input type="text" id="departamentEmployeePermissBacku" class="form-control" disabled>

                <label for="datePermissBacku" class="form-label  fw-bold">Fecha</label>
                <input type="text" name="datesingleAdmin" class="form-control" id="datePermissBacku">
                <label for="motivo" class="form-label  fw-bold">Estado</label>
                <select name="selectStatePermissBacku" id="selectStatePermissBacku" class="form-select">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnEmployeePermissBacku" class="btn btn-dark w-100">Enviar</button>
          </div>
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
    var titulo = "Permisos atrasados";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;
  </script>
  <script>

    getDataPermissBack();
    document.getElementById("campo_permissBack").addEventListener("keyup", function () {
      document.getElementById("pagina_permissBack").value = 1;
      getDataPermissBack();
    }, false)
    document.getElementById("num_registros_permissBack").addEventListener("change", function () {
      document.getElementById("pagina_permissBack").value = 1;
      getDataPermissBack();
    }, false)


    function getDataPermissBack() {
      let input = document.getElementById("campo_permissBack").value;
      let num_registros = document.getElementById("num_registros_permissBack").value;
      let content = document.getElementById("content_permissBack");
      let pagina = document.getElementById("pagina_permissBack").value;
      let orderCol = document.getElementById("orderCol_permissBack").value;
      let orderType = document.getElementById("orderType_permissBack").value;
      let idEmployee = document.getElementById("idEmployeeSelectedPermissBack").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tablePermissBack.php";
      let formaData = new FormData();
      formaData.append('campo', input);
      formaData.append('registros', num_registros);
      formaData.append('pagina', pagina);
      formaData.append('orderCol', orderCol);
      formaData.append('orderType', orderType);
      formaData.append('idEmployee', idEmployee);


      fetch(url, {
        method: "POST",
        body: formaData
      }).then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById("lbl-total-permissBack").innerHTML = 'Mostrando ' + data.totalFiltro +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion-permissBack").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPagePermissBack(pagina) {
      document.getElementById('pagina_permissBack').value = pagina;
      getDataPermissBack();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenarPërmissBack);
    }

    function ordenarPërmissBack(e) {
      let elemento = e.target;

      document.getElementById('orderCol_permissBack').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType_permissBack").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType_permissBack").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getDataPermissBack();

    }



  </script>
</body>

</html>