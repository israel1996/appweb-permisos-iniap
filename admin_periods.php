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


  <section class="container-fluid" style="margin-top: 100px;">
    <input type="text" id="idEmployeeSelectedPeriod" style="display: none;" value="0">

    <div class="container">

      <div class="row g-4">
        <div class="col-auto">
          <div id="slotSearchEmployeePeriod"></div>
        </div>
        <div class="col-auto" style="margin-top: 45px; margin-left: -20px;">
          <button type="button" id="btnOptionsPeriod" class="btn btn-dark">
            <span>
              <img src="assets/icons/list.svg" alt="Descripción de la imagen">
            </span>
            Opciones
          </button>
        </div>



        <div class="col-2"></div>
        <div class="col-auto" style="margin-top: 45px " ;>
          <label for="num_registros" class="col-form-label fw-bold">Buscar: </label>
        </div>
        <div class="col-auto" style="margin-top: 45px " ;>
          <input type="text" name="campo" id="campo_period" class="form-control" placeholder="Escriba aquí...">
        </div>
        <div class="col-auto" style="margin-top: 45px " ;>
          <label for="num_registros" class="col-form-label fw-bold">Mostrar: </label>
        </div>
        <div class="col-auto" style="margin-top: 45px " ;>
          <select name="num_registros" id="num_registros_period" class="form-select">
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
              <th class="align-middle">ID Periodo</th>
              <th class="align-middle">Empleado</th>
              <th class="align-middle">Inicio de Periodo</th>
              <th class="align-middle">Fin de Periodo</th>
              <th class="align-middle">Dias Ganados</th>
              <th class="align-middle">Saldo Dias Laborales</th>
              <th class="align-middle">Saldo Fines de Semana</th>
              <th class="align-middle">Total de Saldos</th>
              <th class="align-middle">Editar</th>
            </tr>
          </thead>
          <tbody id="content_period">
          </tbody>
        </table>

        <!-- Paginacion Periodos -->
        <div class="row">
          <div class="col-5">
            <label id="lbl-total-period"></label>
          </div>
          <div class="col-7" id="nav-paginacion-period"></div>
          <input type="hidden" id="pagina_period" value="1">
          <input type="hidden" id="orderCol_period" value="0">
          <input type="hidden" id="orderType_period" value="asc">
        </div>

      </div>
    </div>
    

    <!-- Modal Generar Periodos -->
    <div class="modal fade" id="modalEmployeePeriod" tabindex="-1" aria-labelledby="modalEmployeePeriodLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEmployeePeriodLabel">Periodo de Vacaciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="cedulaEmployeePeriod" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeePeriod" class="form-control" disabled>

                <label for="nameEmployeePeriod" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeePeriod" class="form-control" disabled>

                <label for="lastNameEmployeePeriod" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeePeriod" class="form-control" disabled>
              </div>

              <div class="col-md-6">
                <label for="departamentEmployeePeriod" class="form-label fw-bold">Departamento</label>
                <input type="text" name="departamentEmployeePeriod" id="departamentEmployeePeriod" class="form-control"
                  disabled>

                <label for="startDateEmployeePeriod" class="form-label  fw-bold">Fecha de Inicio Laboral</label>
                <input type="date" name="startDateEmployeePeriod" class="form-control" id="startDateEmployeePeriod"
                  disabled>

                <br />
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="chExtraPeriod"
                    style="width: 20px; height: 20px; border: 2px solid #969696;">
                  <label class="form-check-label fw-bold" for="chExtraPeriod">Adelantar Periodo</label>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnGeneratePeriods" class="btn btn-success w-100">Generar</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal para actualizar Periodo -->
    <div class="modal fade" id="modalPeriodUpdate" tabindex="-1" aria-labelledby="modalVacationLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoLabel">Editar Periodo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <input type="text" name="idPeriod" id="idPeriod" class="form-control" value="0" hidden>

                <label for="cedulaEmployeePeriodu" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeePeriodu" class="form-control" disabled>

                <label for="nameEmployeePeriodu" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeePeriodu" class="form-control" disabled>

                <label for="lastNameEmployeePeriodu" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeePeriodu" class="form-control" disabled>

                <label for="departamentEmployeePeriodu" class="form-label fw-bold">Departamento</label>
                <input type="text" name="departamentEmployeePeriodu" id="departamentEmployeePeriodu"
                  class="form-control" disabled>

                <label for="cedulaEmployeeVacation" class="form-label fw-bold">Inicio de Periodo</label>
                <input type="text" name="datesingleAdmin" id="startDatePeriod" class="form-control">

                <label for="nameEmployeeVacation" class="form-label fw-bold">Fin de Periodo</label>
                <input type="text"  name="datesingleAdmin" id="endDatePeriod" class="form-control">

              </div>

              <div class="col-md-6">
                <label for="lastNameEmployeeVacation" class="form-label fw-bold">Dias Ganados</label>
                <input type="text" name="numeric" id="earnDaysPeriod" class="form-control" disabled>

                <label for="cedulaEmployeeVacation" class="form-label fw-bold">Saldo Dias Laborales</label>
                <input type="text" name="decimal" id="workingDaysPeriod" class="form-control">

                <label for="nameEmployeeVacation" class="form-label fw-bold">Saldo Dias de Fin de Semana</label>
                <input type="text" name="decimal" id="weekendDaysPeriod" class="form-control">

                <label for="lastNameEmployeeVacation" class="form-label fw-bold">Total de Saldos</label>
                <input type="text" name="decimal" id="balanceDaysPeriod" class="form-control" disabled>

                <label for="selectStatePeriod" class="form-label  fw-bold">Estado</label>
                <select name="selectStatePeriod" id="selectStatePeriod" class="form-select">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnUpadatePeriod" class="btn btn-success w-100">Guardar Cambios</button>
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
    var titulo = "Gestión de Periodos";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;


    var campo1 = document.getElementById("workingDaysPeriod");
    var campo2 = document.getElementById("weekendDaysPeriod");
    var campo3 = document.getElementById("balanceDaysPeriod");

    campo1.addEventListener("input", actualizarSuma);
    campo2.addEventListener("input", actualizarSuma);

    function actualizarSuma() {
      var valor1 = parseFloat(campo1.value) || 0; // Si el valor es inválido, se asume 0
      var valor2 = parseFloat(campo2.value) || 0;
      var suma = valor1 + valor2;
      campo3.value = suma.toFixed(2);
    }
  </script>

  <script>

    getDataPeriods();
    document.getElementById("campo_period").addEventListener("keyup", function () {
      document.getElementById("pagina_period").value = 1;
      getDataPeriods();
    }, false)
    document.getElementById("num_registros_period").addEventListener("change", function () {
      document.getElementById("pagina_period").value = 1;
      getDataPeriods();
    }, false)


    function getDataPeriods() {
      let input = document.getElementById("campo_period").value;
      let num_registros = document.getElementById("num_registros_period").value;
      let content = document.getElementById("content_period");
      let pagina = document.getElementById("pagina_period").value;
      let orderCol = document.getElementById("orderCol_period").value;
      let orderType = document.getElementById("orderType_period").value;
      let idEmployee = document.getElementById("idEmployeeSelectedPeriod").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tablePeriods.php";
      let formaData = new FormData();
      formaData.append('campo_period', input);
      formaData.append('registros_period', num_registros);
      formaData.append('pagina_period', pagina);
      formaData.append('orderCol_period', orderCol);
      formaData.append('orderType_period', orderType);
      formaData.append('idEmployeeSelectedPeriod', idEmployee);


      fetch(url, {
        method: "POST",
        body: formaData
      }).then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById("lbl-total-period").innerHTML = 'Mostrando ' + data.totalFiltro +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion-period").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPagePeriod(pagina) {
      document.getElementById('pagina_period').value = pagina;
      getDataPeriods();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenarPeriod);
    }

    function ordenarPeriod(e) {
      let elemento = e.target;

      document.getElementById('orderCol_period').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType_period").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType_period").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getDataPeriods();

    }

    var modalPeriodUpdate = document.getElementById("modalPeriodUpdate");

    modalPeriodUpdate.addEventListener("show.bs.modal", function () {
      idPeriod = $('#idPeriod').val();

      var cadena = "id=" + idPeriod;
      //alert(cadena);
      /*
        $.ajax({
          type: "POST",
          data: cadena,
          dataType: "json",
          url: './assets/php/getDataEmployee.php',
          success: function (response) {
            $('#cedulaEmployeePeriodu').val(response.ci_employee);
            $('#nameEmployeePeriodu').val(response.name_employee);
            $('#lastNameEmployeePeriodu').val(response.lastName_employee);
            $('#departamentEmployeePeriodu').val(response.name_departament);

          },
          error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
          } 
        });  */
    });



  </script>


</body>

</html>