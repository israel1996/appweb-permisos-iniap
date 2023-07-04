<?php
include 'assets/php/sessionChecker.php';

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

  <section class="container" style="margin-top: 100px;">
    <nav>
      <div class="nav nav-pills nav-justified" id="nav-tab" roles="tablist">

        <button class="nav-link active custom" id="nav-departament-tab" data-bs-toggle="tab"
          data-bs-target="#departaments" type="button" role="tab" aria-controls="nav-departament"
          aria-selected="true">Departamentos</button>

        <button class="nav-link custom" id="nav-reasonPermise-tab" data-bs-toggle="tab" data-bs-target="#reasonPermise"
          type="button" role="tab" aria-controls="nav-reasonpermises" aria-selected="true">Razones de Permiso</button>

        <button class="nav-link custom" id="nav-contractType-tab" data-bs-toggle="tab" data-bs-target="#contractType"
          type="button" role="tab" aria-controls="nav-contractType" aria-selected="true">Tipos de Contratación</button>

        <button class="nav-link custom" id="nav-jobTitle-tab" data-bs-toggle="tab" data-bs-target="#jobTitle"
          type="button" role="tab" aria-controls="nav-jobTitle" aria-selected="true">Cargos</button>

    </nav>
    <div class="tab-content" id="tab-content">
      <div id="departaments" class="tab-pane fade show active">

        <!--Campo de Entrada, botón, Seleccionador de Registros y busqueda -->
        <div class="row g-4" style="margin-top: 5px;">
          <div class="col-auto">
            <input type="text" hidden="" id="idDepartament" name="">
            <label for="nameDepartament" class="col-form-label fw-bold">Nombre:</label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" id="nameDepartament" placeholder="Escriba aqui...">
          </div>
          <div class="col-auto">
            <button type="button" id="btnAddDepartament" class="btn btn-dark w-100">Agregar Nuevo</button>
            <button type="button" id="btnUpdateDepartament" class="btn btn-success w-100">Guardar Cambios</button>
          </div>
          <div class="col-1"></div>
          <div class="col-auto">
            <label for="campo_departament" class="col-form-label fw-bold">Buscar: </label>
          </div>
          <div class="col-auto">
            <input type="text" name="campo_departament" id="campo_departament" class="form-control"
              placeholder="Escriba aquí...">
          </div>
          <div class="col-auto">
            <label for="num_registros_departament" class="col-form-label fw-bold">Mostrar: </label>
          </div>
          <div class="col-auto">
            <select name="num_registros_departament" id="num_registros_departament" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
          </div>
        </div>

        <!-- Tabla Departamentos -->
        <div class="row justify-content-center">
          <div class="col-6">
            <table class="table table-hover mt-4">
              <thead class="">
                <tr class="text-center">
                  <th class="align-middle">ID Departamento</th>
                  <th class="align-middle">Nombre de Departamento</th>
                  <th class="align-middle">Editar</th>
                  <th class="align-middle">Eliminar</th>
                </tr>
              </thead>
              <tbody id="content_departament">
              </tbody>
            </table>

            <!-- Paginacion Departamentos -->
            <div class="row">
              <div class="col-5">
                <label id="lbl-total-departament"></label>
              </div>
              <div class="col-7" id="nav-paginacion-departament"></div>
              <input type="hidden" id="pagina_departament" value="1">
              <input type="hidden" id="orderCol_departament" value="0">
              <input type="hidden" id="orderType_departament" value="asc">
            </div>

          </div>
        </div>
      </div>

      <div id="reasonPermise" class="tab-pane fade">

        <!--Campo de Entrada, botón, Seleccionador de Registros y busqueda -->
        <div class="row g-4" style="margin-top: 5px;">
          <div class="col-auto">
            <input type="text" hidden="" id="idReason" name="">
            <label for="nameReason" class="col-form-label fw-bold">Nombre:</label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" id="nameReason" placeholder="Escriba aqui...">
          </div>
          <div class="col-auto">
            <button type="button" id="btnAddReason" class="btn btn-dark w-100">Agregar Nuevo</button>
            <button type="button" id="btnUpdateReason" class="btn btn-success w-100">Guardar Cambios</button>
          </div>
          <div class="col-1"></div>
          <div class="col-auto">
            <label for="campo_reason" class="col-form-label fw-bold">Buscar:</label>
          </div>
          <div class="col-auto">
            <input type="text" name="campo_reason" id="campo_reason" class="form-control" placeholder="Escriba aquí...">
          </div>
          <div class="col-auto">
            <label for="num_registros_reason" class="col-form-label fw-bold">Mostrar:</label>
          </div>
          <div class="col-auto">
            <select name="num_registros_reason" id="num_registros_reason" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
          </div>
        </div>


        <!-- Tabla Razones -->
        <div class="row justify-content-center">
          <div class="col-6">
            <table class="table table-hover mt-4">
              <thead class="">
                <tr class="text-center">
                  <th class="align-middle">ID Motivo</th>
                  <th class="align-middle">Motivo de Permiso</th>
                  <th class="align-middle">Editar</th>
                  <th class="align-middle">Eliminar</th>
                </tr>
              </thead>
              <tbody id="content_reason">
              </tbody>
            </table>

            <!-- Paginacion Razones -->
            <div class="row">
              <div class="col-5">
                <label id="lbl-total-reason"></label>
              </div>
              <div class="col-7" id="nav-paginacion-reason"></div>
              <input type="hidden" id="pagina_reason" value="1">
              <input type="hidden" id="orderCol_reason" value="0">
              <input type="hidden" id="orderType_reason" value="asc">
            </div>

          </div>
        </div>
      </div>

      <div id="contractType" class="tab-pane fade">

        <!--Campo de Entrada, botón, Seleccionador de Registros y busqueda -->
        <div class="row g-4" style="margin-top: 5px;">
          <div class="col-auto">
            <input type="text" hidden="" id="idContractType" name="">
            <label for="nameContractType" class="col-form-label fw-bold">Nombre:</label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" id="nameContractType" placeholder="Escriba aqui...">
          </div>
          <div class="col-auto">
            <button type="button" id="btnAddContractType" class="btn btn-dark w-100">Agregar Nuevo</button>
            <button type="button" id="btnUpdateContractType" class="btn btn-success w-100">Guardar Cambios</button>
          </div>
          <div class="col-1"></div>
          <div class="col-auto">
            <label for="campo_contractType" class="col-form-label fw-bold">Buscar:</label>
          </div>
          <div class="col-auto">
            <input type="text" name="campo_contractType" id="campo_contractType" class="form-control"
              placeholder="Escriba aquí...">
          </div>
          <div class="col-auto">
            <label for="num_registros_contractType" class="col-form-label fw-bold">Mostrar:</label>
          </div>
          <div class="col-auto">
            <select name="num_registros_contractType" id="num_registros_contractType" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
          </div>
        </div>

        <!-- Tabla Tipos de Contrato -->
        <div class="row justify-content-center">
          <div class="col-6">
            <table class="table table-hover mt-4">
              <thead class="">
                <tr class="text-center">
                  <th class="align-middle">ID Tipo de Cotratación</th>
                  <th class="align-middle">Nombre de Contratación</th>
                  <th class="align-middle">Editar</th>
                  <th class="align-middle">Eliminar</th>
                </tr>
              </thead>
              <tbody id="content_contractType">
              </tbody>
            </table>
          </div>
        </div>

        <!-- Paginacion Tipos de Contrato -->
        <div class="row">
          <div class="col-5">
            <label id="lbl-total-contractType"></label>
          </div>
          <div class="col-7" id="nav-paginacion-contractType"></div>
          <input type="hidden" id="pagina_contractType" value="1">
          <input type="hidden" id="orderCol_contractType" value="0">
          <input type="hidden" id="orderType_contractType" value="asc">
        </div>
      </div>


      <div id="jobTitle" class="tab-pane fade">

        <!--Campo de Entrada, botón, Seleccionador de Registros y busqueda -->
        <div class="row g-4" style="margin-top: 5px;">
          <div class="col-auto">
            <input type="text" hidden="" id="idJobTitle" name="">
            <label for="nameJobTitle" class="col-form-label fw-bold">Nombre:</label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" id="nameJobTitle" placeholder="Escriba aqui...">
          </div>
          <div class="col-auto">
            <button type="button" id="btnAddJobTitle" class="btn btn-dark w-100">Agregar Nuevo</button>
            <button type="button" id="btnUpdateJobTitle" class="btn btn-success w-100">Guardar Cambios</button>
          </div>
          <div class="col-1"></div>
          <div class="col-auto">
            <label for="campo_jobTitle" class="col-form-label fw-bold">Buscar:</label>
          </div>
          <div class="col-auto">
            <input type="text" name="campo_jobTitle" id="campo_jobTitle" class="form-control"
              placeholder="Escriba aquí...">
          </div>
          <div class="col-auto">
            <label for="num_registros_jobTitle" class="col-form-label fw-bold">Mostrar:</label>
          </div>
          <div class="col-auto">
            <select name="num_registros_jobTitle" id="num_registros_jobTitle" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
          </div>
        </div>

        <!-- Tabla Tipos de Contrato -->
        <div class="row justify-content-center">
          <div class="col-6">
            <table class="table table-hover mt-4">
              <thead class="">
                <tr class="text-center">
                  <th class="align-middle">ID Cargo</th>
                  <th class="align-middle">Nombre de Cargo</th>
                  <th class="align-middle">Editar</th>
                  <th class="align-middle">Eliminar</th>
                </tr>
              </thead>
              <tbody id="content_jobTitle">
              </tbody>
            </table>
          </div>
        </div>

        <!-- Paginacion Tipos de Contrato -->
        <div class="row">
          <div class="col-5">
            <label id="lbl-total-jobTitle"></label>
          </div>
          <div class="col-7" id="nav-paginacion-jobTitle"></div>
          <input type="hidden" id="pagina_jobTitle" value="1">
          <input type="hidden" id="orderCol_jobTitle" value="0">
          <input type="hidden" id="orderType_jobTitle" value="asc">
        </div>
      </div>


    </div>

  </section>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>

  <?php require 'partials/footer.php' ?>

  <script>
    // Initialize
    initializeData("departament");
    initializeData("reason");
    initializeData("contractType");
    initializeData("jobTitle");

    function initializeData(dataType) {
      addInputEventListeners(dataType);
      addSortingEventListeners(dataType);
      getData(dataType);
    }

    function addInputEventListeners(dataType) {
      document.getElementById(`campo_${dataType}`).addEventListener("keyup", function () {
        document.getElementById(`pagina_${dataType}`).value = 1;
        getData(dataType);
      }, false);

      document.getElementById(`num_registros_${dataType}`).addEventListener("change", function () {
        document.getElementById(`pagina_${dataType}`).value = 1;
        getData(dataType);
      }, false);
    }

    function addSortingEventListeners(dataType) {
      let columns = document.getElementsByClassName(`sort_${dataType}`);
      let size = columns.length;
      for (let i = 0; i < size; i++) {
        columns[i].addEventListener("click", function (e) {
          ordenar(e, dataType);
        });
      }
    }

    function getData(dataType) {
      let input = document.getElementById(`campo_${dataType}`).value;
      let num_registros = document.getElementById(`num_registros_${dataType}`).value;
      let content = document.getElementById(`content_${dataType}`);
      let pagina = document.getElementById(`pagina_${dataType}`).value || 1;
      let orderCol = document.getElementById(`orderCol_${dataType}`).value;
      let orderType = document.getElementById(`orderType_${dataType}`).value;

      let url = `./partials/table${capitalize(dataType)}s.php`;
      let formData = new FormData();
      formData.append(`campo_${dataType}`, input);
      formData.append(`registros_${dataType}`, num_registros);
      formData.append(`pagina_${dataType}`, pagina);
      formData.append(`orderCol_${dataType}`, orderCol);
      formData.append(`orderType_${dataType}`, orderType);

      fetch(url, {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById(`lbl-total-${dataType}`).innerHTML = `Mostrando ${data.totalFiltro} de ${data.totalRegistros} registros`;
          document.getElementById(`nav-paginacion-${dataType}`).innerHTML = data.paginacion;
        })
        .catch(err => console.log(err));
    }

    function nextPage(dataType, pagina) {
      let functionName = `nextPage${capitalize(dataType)}`;
      if (typeof window[functionName] === "function") {
        window[functionName](pagina);
      }
    }

    function nextPageDepartament(pagina) {
      document.getElementById('pagina_departament').value = pagina;
      getData("departament");
    }

    function nextPageReason(pagina) {
      document.getElementById('pagina_reason').value = pagina;
      getData("reason");
    }
    function nextPageJobTitle(pagina) {
      document.getElementById('pagina_jobTitle').value = pagina;
      getData("jobTitle");
    }

    function ordenar(e, dataType) {
      let elemento = e.target;
      document.getElementById(`orderCol_${dataType}`).value = elemento.cellIndex;
      if (elemento.classList.contains("asc")) {
        document.getElementById(`orderType_${dataType}`).value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById(`orderType_${dataType}`).value = "desc";
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }
      getData(dataType);
    }
    function capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }
  </script>

</body>

</html>