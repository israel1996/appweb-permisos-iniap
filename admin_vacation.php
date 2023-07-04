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

  
  <!-- Modal PDF -->
  <div class="modal fade" id="modalPDFPermiss" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
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

    <div class="container">

      <input type="hidden" id="idEmployeeSelectedVacation" value="0">


      <div class="row g-4">
        <div class="col-auto">
          <div id="search"></div>
        </div>

        <div class="col-2"></div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <label for="num_registros" class="col-form-label fw-bold">Buscar: </label>
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <input type="text" name="campo" id="campo_vacation" class="form-control" placeholder="Escriba aquí...">
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <label for="num_registros" class="col-form-label fw-bold">Mostrar: </label>
        </div>
        <div class="col-auto" style="margin-top: 50px " ;>
          <select name="num_registros" id="num_registros_vacation" class="form-select">
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
              <th class="align-middle">ID Permiso</th>
              <th class="align-middle">Nombres y Apellidos</th>
              <th class="align-middle">Fecha de Emisión</th>
              <th class="align-middle">Estado</th>
              <th class="align-middle">Dias Laborales</th>
              <th class="align-middle">Dias de Fin de Semana</th>
              <th class="align-middle">Total</th>
              <th class="align-middle">Observación</th>
              <th class="align-middle">Detalles</th>
            </tr>
          </thead>
          <tbody id="content_vacation">
          </tbody>
        </table>

        <!-- Paginacion Periodos -->
        <div class="row">
          <div class="col-5">
            <label id="lbl-total-vacation"></label>
          </div>
          <div class="col-7" id="nav-paginacion-vacation"></div>
          <input type="hidden" id="pagina_vacation" value="1">
          <input type="hidden" id="orderCol_vacation" value="0">
          <input type="hidden" id="orderType_vacation" value="desc">
        </div>

      </div>
    </div>

    <!-- Modal para solicitar Vacaciones -->
    <div class="modal fade" id="modalVacation" tabindex="-1" aria-labelledby="modalVacationLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoLabel">Formulario de Vacaciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="cedulaEmployeeVacation" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeeVacation" class="form-control" disabled>

                <label for="nameEmployeeVacation" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeeVacation" class="form-control" disabled>

                <label for="lastNameEmployeeVacation" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeeVacation" class="form-control" disabled>

                <label for="departamentEmployeeVacation" class="form-label fw-bold">Departamento</label>
                <input type="text" id="departamentEmployeeVacation" class="form-control" disabled>
              </div>

              <div class="col-md-6">
                <label for="fecha-inicio" class="form-label  fw-bold">Rango de Fecha</label>
                <input type="text" name="daterangeAdmin" class="form-control" id="rangeDateVacation">
                <label for="motivo" class="form-label  fw-bold">Motivo</label>
                <select name="selectReason" id="selectReasonVacation" class="form-select" disabled>
                  <?php
                  $sql = " SELECT id_reason, name_reason FROM tb_reason WHERE LOWER(name_reason) LIKE '%vacaciones%'";
                  $result = $conn->query($sql);
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
                <label for="observacion" class="form-label  fw-bold">Observación</label>
                <textarea class="form-control" id="observationVacation" rows="4"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSendRequestPermissDateVacation" class="btn btn-dark w-100">Enviar</button>
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
    var titulo = "Formulario de Vacaciones";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;
  </script>

  <script>

    getDataVacation();
    document.getElementById("campo_vacation").addEventListener("keyup", function () {
      document.getElementById("pagina_vacation").value = 1;
      getDataVacation();
    }, false)
    document.getElementById("num_registros_vacation").addEventListener("change", function () {
      document.getElementById("pagina_vacation").value = 1;
      getDataVacation();
    }, false)


    function getDataVacation() {
      let input = document.getElementById("campo_vacation").value;
      let num_registros = document.getElementById("num_registros_vacation").value;
      let content = document.getElementById("content_vacation");
      let pagina = document.getElementById("pagina_vacation").value;
      let orderCol = document.getElementById("orderCol_vacation").value;
      let orderType = document.getElementById("orderType_vacation").value;
      let idEmployee = document.getElementById("idEmployeeSelectedVacation").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tableEmployeeVacation.php";
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
          document.getElementById("lbl-total-vacation").innerHTML = 'Mostrando ' + data.totalFiltro +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion-vacation").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPageVacation(pagina) {
      document.getElementById('pagina_vacation').value = pagina;
      getDataVacation();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenarVacation);
    }

    function ordenarVacation(e) {
      let elemento = e.target;

      document.getElementById('orderCol_vacation').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType_vacation").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType_vacation").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getDataVacation();

    }



  </script>

</body>

</html>