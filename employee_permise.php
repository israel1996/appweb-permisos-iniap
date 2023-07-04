<?php
include 'assets/php/sessionChecker.php';
include_once "assets/php/database.php";

$idEmployee = 0;
if (isset($_SESSION['user'])) {
  $user = unserialize($_SESSION['user']);
  $idEmployee = $user->getIdEmployee();
}

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

  <input type="hidden" id="idEmployee" value="<?php echo $idEmployee ?>">

    <!-- Modal -->
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



    <nav>
      <div class="nav nav-pills nav-justified" id="nav-tab" roles="tablist">

        <button class="nav-link active custom" id="nav-departament-tab" data-bs-toggle="tab" data-bs-target="#forDate"
          type="button" role="tab" aria-controls="nav-forDate" aria-selected="true">Por Dias</button>

        <button class="nav-link custom" id="nav-reasonPermise-tab" data-bs-toggle="tab" data-bs-target="#forDay"
          type="button" role="tab" aria-controls="nav-forDay" aria-selected="true">Por Horas</button>


    </nav>
    <div class="tab-content" id="tab-content">
      <div id="forDate" class="tab-pane fade show active" style="margin-top:50px">
        <!-- Fila Principal 1 -->
        <input type="hidden" id="idPermiss" value="0">

        <div class="row">

          <!-- Columna 1 -->
          <div class="col-sm-4">

            <div class="container">

              <div class="row">
                <div class="col">
                  <label for="fecha-inicio" class="form-label  fw-bold">Rango de Fecha</label>
                  <input type="text" name="daterange" class="form-control" id="rangeDate">
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <label for="motivo" class="form-label  fw-bold">Motivo</label>
                  <select name="selectReason" id="selectReason" class="form-select">
                    <!-- Opciones de la lista aquí -->
                    <?php
                    $sql = "SELECT id_reason, name_reason FROM tb_reason";
                    $result = $conn->query($sql);

                    // Generar las opciones del select
                    if ($result->rowCount() > 0) {
                      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row["id_reason"] . '">' . $row["name_reason"] . '</option>';
                      }
                    } else {
                      echo '<option value="">No hay datos disponibles</option>';
                    }
                    $result->closeCursor();

                    ?>
                  </select>
                </div>
              </div>


              <div class="row">
                <div class="col">
                  <label for="observacion" class="form-label  fw-bold">Observación</label>
                  <textarea class="form-control" id="txtObservation" rows="3"></textarea>
                </div>
              </div>

              <div class="row" style="margin-top:20px">
                <div class="col">
                  <button type="button" id="btnSendRequestPermissDate" class="btn btn-dark w-100">Enviar</button>
                </div>
              </div>


            </div>
          </div>
          <!-- Columna 2 -->
          <div class="col-sm-8">
            <!-- Tabla Permisos por fecha -->
            <div class="row">
              <table class="table table-hover mt-1">
                <thead class="">
                  <tr class="text-center">
                    <th class="align-middle">Fecha de Emisión</th>
                    <th class="align-middle">Estado</th>
                    <th class="align-middle">Motivo</th>
                    <th class="align-middle">Dias Laborales</th>
                    <th class="align-middle">Dias de Fin de Semana</th>
                    <th class="align-middle">Total</th>
                    <th class="align-middle">Observación</th>
                    <th class="align-middle">Detalles</th>
                  </tr>
                </thead>
                <tbody id="content_permissDate">
                </tbody>
              </table>
            </div>

            <!-- Paginacion Permisos por fecha -->
            <div class="row">
              <div class="col-3">
                <label id="lbl-total-permissDate"></label>
              </div>
              <!-- Número de Registros -->
              <div class="col-1" ;>
                <select name="num_registros_permissDate" id="num_registros_permissDate" class="form-select">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                </select>
              </div>

              <div class="col-7" id="nav-paginacion-permissDate"></div>
              <input type="hidden" id="pagina_permissDate" value="1">
              <input type="hidden" id="orderCol_permissDate" value="0">
              <input type="hidden" id="orderType_permissDate" value="desc">

            </div>
          </div>
        </div>

      </div>

      <div id="forDay" class="tab-pane fade" style="margin-top:50px">
        <!-- Fila Principal 1 -->
        <div class="row">

          <!-- Columna 1 -->
          <div class="col-sm-4">

            <div class="container">
              <div class="row">
                <div class="col">
                  <label for="dateDay" class="form-label  fw-bold">Fecha</label>
                  <input type="text" name="datesingle" class="form-control" id="dateDay"></input>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <label for="fecha-inicio" class="form-label  fw-bold">Hora Inicial</label>
                  <input type="text" name="timeSelector" class="form-control" id="timeStart" readonly>
                </div>
                <div class="col">
                  <label for="fecha-fin" class="form-label  fw-bold">Hora Final</label>
                  <input type="text" name="timeSelector" class="form-control" id="timeEnd" readonly>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <label for="motivo" class="form-label  fw-bold">Motivo</label>
                  <select name="selectReason" id="selectReasonDay" class="form-select">
                    <!-- Opciones de la lista aquí -->
                    <?php
                    $sql = "SELECT id_reason, name_reason FROM tb_reason";
                    $result = $conn->query($sql);

                    // Generar las opciones del select
                    if ($result->rowCount() > 0) {
                      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row["id_reason"] . '">' . $row["name_reason"] . '</option>';
                      }
                    } else {
                      echo '<option value="">No hay datos disponibles</option>';
                    }
                    $result->closeCursor();

                    ?>
                  </select>
                </div>
              </div>


              <div class="row">
                <div class="col">
                  <label for="observacion" class="form-label  fw-bold">Observación</label>
                  <textarea class="form-control" id="observationDay" rows="3"></textarea>
                </div>
              </div>

              <div class="row " style="margin-top:20px; margin-bottom:20px">
                <div class="col">
                  <button type="button" id="btnSendRequestPermissDay" class="btn btn-dark w-100">Enviar</button>
                </div>
              </div>


            </div>
          </div>
          <!-- Columna 2 -->
          <div class="col-sm-8">
            <!-- Tabla Permisos por horas -->
            <div class="row">
              <table class="table table-hover mt-1">
                <thead class="">
                  <tr class="text-center">
                    <th class="align-middle">Fecha de Emisión</th>
                    <th class="align-middle">Estado</th>
                    <th class="align-middle">Motivo</th>
                    <th class="align-middle">Dias Laborales</th>
                    <th class="align-middle">Dias de Fin de Semana</th>
                    <th class="align-middle">Total</th>
                    <th class="align-middle">Observación</th>
                    <th class="align-middle">Detalles</th>
                  </tr>
                </thead>
                <tbody id="content_permissDay">
                </tbody>
              </table>
            </div>

            <!-- Paginacion permisos por horas -->
            <div class="row">
              <div class="col-3">
                <label id="lbl-total-permissDay"></label>
              </div>
              <!-- Número de Registros -->
              <div class="col-1" ;>
                <select name="num_registros_permissDay" id="num_registros_permissDay" class="form-select">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                </select>
              </div>

              <div class="col-7" id="nav-paginacion-permissDay"></div>
              <input type="hidden" id="pagina_permissDay" value="1">
              <input type="hidden" id="orderCol_permissDay" value="0">
              <input type="hidden" id="orderType_permissDay" value="desc">

            </div>
          </div>
        </div>

      </div>


  </section>

  <?php require 'partials/footer.php' ?>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>

  <script>
    // Initialize
    initializeData("permissDate");
    initializeData("permissDay");

    function initializeData(dataType) {
      addInputEventListeners(dataType);
      addSortingEventListeners(dataType);
      getData(dataType);
    }

    function addInputEventListeners(dataType) {
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
      let num_registros = document.getElementById(`num_registros_${dataType}`).value;
      let content = document.getElementById(`content_${dataType}`);
      let pagina = document.getElementById(`pagina_${dataType}`).value || 1;
      let orderCol = document.getElementById(`orderCol_${dataType}`).value;
      let orderType = document.getElementById(`orderType_${dataType}`).value;


      let url = `./partials/table${capitalize(dataType)}.php`;
      let formData = new FormData();
      formData.append(`registros`, num_registros);
      formData.append(`pagina`, pagina);
      formData.append(`orderCol`, orderCol);
      formData.append(`orderType`, orderType);


      fetch(url, {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          content.innerHTML = data.data;
          document.getElementById(`lbl-total-${dataType}`).innerHTML = `Mostrando ${data.totalRegistros} de ${data.totalRegistros} registros`;
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

    function nextPageDiscountDate(pagina) {
      document.getElementById('pagina_discountDate').value = pagina;
      getData("discountDate");
    }

    function nextPageDiscountDay(pagina) {
      document.getElementById('pagina_discountDay').value = pagina;
      getData("discountDay");
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