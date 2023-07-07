<?php
include 'assets/php/sessionChecker.php';
unset($_SESSION['id_employee_search']);

require_once "assets/php/dom.php";
require_once "assets/php/database.php";
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

  <div class="container py-4 text-center"></div>

  <section class="container" style="margin-top: 50px;">

  <!-- Modal PDF -->
  <div class="modal fade" id="modalReportPermiss" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Reporte de Permisos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- iframe para cargar el PDF -->
            <iframe id="pdfFramePermiss" src="" width="100%" height="500px"></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Boton de Agregar, seleccionador de Registros y busqueda -->
    <div class="row g-4">
      <div class="col-auto">
      <button class="btn btn-dark text-white" id="btnReportPermiss" style="margin-top:-2px"> Generar PDF </button>
      </div>
      <div class="col-auto">
        <label for="num_registros" class="col-form-label fw-bold">Buscar: </label>
      </div>
      <div class="col-auto">
        <input type="text" name="campo" id="campo" class="form-control" placeholder="Escriba aquí...">
      </div>
      <div class="col-auto">
      <label for="num_registros" class="col-form-label fw-bold">Fechas: </label>
      </div>
      <div class="col-1">
        <input type="text" name="dateInput" id="startDate" class="form-control" placeholder="Inicial..." style="width: 110px;">
      </div>
      <div class="col-1">
        <input type="text" name="dateInput" id="endDate" class="form-control" placeholder="Final..." style="width: 110px; " disabled>
      </div>
      <div class="col-auto"></div>
      <div class="col-auto">
        <label for="num_registros" class="col-form-label fw-bold">Mostrar: </label>
      </div>
      <div class="col-auto">
        <select name="num_registros" id="num_registros" class="form-select">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
          <option value="50">50</option>
          <option value="0">Todos</option>
        </select>
      </div>
    </div>

    <!-- Tabla -->
    <div class="row justify-content-center">
      <div class="col-12">
        <table class="table table-hover mt-2">
          <thead class="">
            <tr class="text-center">
              <th class="align-middle">Cedula</th>
              <th class="align-middle">Nombres y Apellidos</th>
              <th class="align-middle">Estado</th>
              <th class="align-middle">Fecha Inicial</th>
              <th class="align-middle">Fecha Final</th>
              <th class="align-middle">D. Laborables</th>
              <th class="align-middle">D. Fin de Semana</th>
              <th class="align-middle">Total</th>
            </tr>
          </thead>
          <tbody id="content">
          </tbody>
        </table>
      </div>
      <!-- Paginacion -->
      <div class="row">
        <div class="col-5">
          <label id="lbl-total"></label>
        </div>
        <div class="col-7" id="nav-paginacion"></div>
        <input type="hidden" id="pagina" value="1">
        <input type="hidden" id="orderCol" value="0">
        <input type="hidden" id="orderType" value="asc">
      </div>
    </div>

  </section>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>
  <script src="assets/js/validations.js"></script>

  <script>
    var titulo = "Reporte de Permisos";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;

    document.getElementById('startDate').addEventListener('input', function(e) {
    let startDateValue = e.target.value;
    let datePattern = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/; // Formato DD/MM/YYYY

    if(datePattern.test(startDateValue)){
        document.getElementById('endDate').disabled = false;
    }else{
        document.getElementById('endDate').disabled = true;
    }
});

  </script>

  <script>
    /* Llamando a la función getData() */
    getData();

    /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
    document.getElementById("campo").addEventListener("keyup", function () {
      document.getElementById("pagina").value = 1;
      getData();
    }, false);
    document.getElementById("num_registros").addEventListener("change", function () {
      document.getElementById("pagina").value = 1;
      getData();
    }, false);
    document.getElementById("endDate").addEventListener("keyup", function () {
      document.getElementById("pagina").value = 1;
      getData();
    }, false);



    /* Peticion AJAX */
    function getData() {
      let input = document.getElementById("campo").value;
      let num_registros = document.getElementById("num_registros").value;
      let content = document.getElementById("content");
      let pagina = document.getElementById("pagina").value;
      let orderCol = document.getElementById("orderCol").value;
      let orderType = document.getElementById("orderType").value;
      let startDate = document.getElementById("startDate").value;
      let endDate = document.getElementById("endDate").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tableReportPermiss.php";
      let formaData = new FormData();
      formaData.append('campo', input);
      formaData.append('registros', num_registros);
      formaData.append('pagina', pagina);
      formaData.append('orderCol', orderCol);
      formaData.append('orderType', orderType);
      formaData.append('startDate', startDate);
      formaData.append('endDate', endDate);

      fetch(url, {
        method: "POST",
        body: formaData
      }).then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPage(pagina) {
      document.getElementById('pagina').value = pagina;
      getData();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenar);
    }

    function ordenar(e) {
      let elemento = e.target;

      document.getElementById('orderCol').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getData();
    }

  </script>

  <?php require 'partials/footer.php' ?>


</body>

</html>