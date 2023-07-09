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

    <input type="hidden" id="idEmployeeSelectedRow" value="0">

    <!-- Modal Generar Certificado -->
    <div class="modal fade" id="modalEmployeeCertificate" tabindex="-1" aria-labelledby="modalEmployeeCertificateLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEmployeeCertificateLabel">Generar Certificado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="cedulaEmployeeCertificate" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeeCertificate" class="form-control" disabled>

                <label for="nameEmployeeCertificate" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeeCertificate" class="form-control" disabled>

                <label for="lastNameEmployeeCertificate" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeeCertificate" class="form-control" disabled>
              </div>

              <div class="col-md-6">
                <label for="departamentEmployeeCertificate" class="form-label fw-bold">Departamento</label>
                <input type="text" name="departamentEmployeeCertificate" id="departamentEmployeeCertificate" class="form-control"
                  disabled>

                <label for="startDateEmployeeCertificate" class="form-label  fw-bold">Fecha de Inicio Laboral</label>
                <input type="date" name="startDateEmployeeCertificate" class="form-control" id="startDateEmployeeCertificate"
                  disabled>

                <br />
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="chRMU"
                    style="width: 20px; height: 20px; border: 2px solid #969696;">
                  <label class="form-check-label fw-bold" for="chRMU">Remuneración</label>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnGenerateCertificate" class="btn btn-success w-100">Generar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Boton de Agregar, seleccionador de Registros y busqueda -->
    <div class="row g-4">
      <div class="col-auto">
        <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#modalNuevo">
          Agregar nuevo
          <span class="glyphicon glyphicon-plus"></span>
        </button>
      </div>
      <div class="col-5"></div>
      <div class="col-auto">
        <label for="num_registros" class="col-form-label fw-bold">Buscar: </label>
      </div>
      <div class="col-auto">
        <input type="text" name="campo" id="campo" class="form-control" placeholder="Escriba aquí...">
      </div>
      <div class="col-auto">
        <label for="num_registros" class="col-form-label fw-bold">Mostrar: </label>
      </div>
      <div class="col-auto">
        <select name="num_registros" id="num_registros" class="form-select">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
        </select>
      </div>
    </div>

    <!-- Tabla -->
    <div class="row justify-content-center">
      <div class="col-12">
        <table class="table table-hover mt-2">
          <thead class="">
            <tr class="text-center">
              <th class="align-middle">ID Empleado</th>
              <th class="align-middle">Cédula</th>
              <th class="align-middle">Nombres</th>
              <th class="align-middle">Apellidos</th>
              <th class="align-middle">Departamento</th>
              <th class="align-middle">Tipo de Código</th>
              <th class="align-middle">Cargo</th>
              <th class="align-middle">F. Inicio Laboral</th>
              <th class="align-middle">Editar</th>
              <th class="align-middle">Desactivar Periodos</th>
              <th class="align-middle">Certificado</th>
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
        <input type="hidden" id="orderType" value="desc">
      </div>
    </div>


    <!-- Modal para registros nuevos -->
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoLabel">Agregar Nuevo Empleado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="idTipoCodigo" class="form-label fw-bold">Tipo de Código</label>
                <select name="idTipoCodigo" id="idTipoCodigo" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_codeType, name_codeType FROM tb_codetype";
                  $result = $conn->query($sql);

                  // Generar las opciones del select
                  if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_codeType"] . '">' . $row["name_codeType"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <label for="idTipoContrato" class="form-label fw-bold">Tipo de Contrato</label>
                <select name="idTipoContrato" id="idTipoContrato" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_typeContract, name_typeContract FROM tb_typecontract";
                  $stmt = $conn->query($sql);

                  // Generar las opciones del select
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_typeContract"] . '">' . $row["name_typeContract"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>

                </select>

                <label for="idDepartamento" class="form-label fw-bold">Departamento</label>
                <select name="idDepartamento" id="idDepartamento" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_departament, name_departament FROM tb_departament";
                  $stmt = $conn->query($sql);

                  // Generar las opciones del select
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_departament"] . '">' . $row["name_departament"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <label for="idJobTitle" class="form-label fw-bold">Cargo</label>
                <select name="idJobTitle" id="idJobTitle" class="form-select">
                  <?php
                  $sql = "SELECT id_jobTitle, name_jobTitle FROM tb_jobTitle";
                  $stmt = $conn->query($sql);

                  // Generar las opciones del select
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_jobTitle"] . '">' . $row["name_jobTitle"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();
                  ?>
                </select>

                <label for="fechaInicioLaboral" class="form-label fw-bold">Fecha de Inicio Laboral</label>
                <input type="text" name="datesingleAdmin" id="fechaInicioLaboral" class="form-control">

                <label for="cedulaEmpleado" class="form-label fw-bold">Cédula de Empleado</label>
                <input type="text" name="cedulaInput" id="cedulaEmpleado" class="form-control" maxlength="10">

              </div>
              <div class="col-md-6">
                <label for="nombreEmpleado" class="form-label fw-bold">Nombres</label>
                <input type="text" name="single-text" id="nombreEmpleado" class="form-control">

                <label for="apellidoEmpleado" class="form-label fw-bold">Apellidos</label>
                <input type="text" name="single-text" id="apellidoEmpleado" class="form-control">

                <label for="telefonoEmpleado" class="form-label fw-bold">Número de Teléfono</label>
                <input type="text" name="numeric" id="telefonoEmpleado" class="form-control" maxlength="10">

                <label for="direccionEmpleado" class="form-label fw-bold">Dirección</label>
                <input type="text" name="direccionEmpleado" id="direccionEmpleado" class="form-control">

                <label for="emailEmpleado" class="form-label fw-bold">Email</label>
                <input type="text" name="email" id="emailEmpleado" class="form-control">

                <label for="salary" class="form-label fw-bold">Remuneración</label>
                <input type="text" name="numeric" id="salary" class="form-control" maxlength="10" placeholder="$00.00">

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success w-100" data-dismiss="modal" id="guardarnuevo">Agregar</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal para editar datos -->
    <div class="modal fade" id="modalEdicion" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoLabel">Editar datos de Empleado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <input type="text" name="idEmployeeu" id="idEmployeeu" class="form-control" hidden>

                <label for="idTipoCodigou" class="form-label fw-bold">Tipo de Código</label>
                <select name="idTipoCodigou" id="idTipoCodigou" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_codeType, name_codeType FROM tb_codetype";
                  $result = $conn->query($sql);

                  // Generar las opciones del select
                  if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_codeType"] . '">' . $row["name_codeType"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <label for="idTipoContratou" class="form-label fw-bold">Tipo de Contrato</label>
                <select name="idTipoContratou" id="idTipoContratou" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_typeContract, name_typeContract FROM tb_typecontract";
                  $stmt = $conn->query($sql);

                  // Generar las opciones del select
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_typeContract"] . '">' . $row["name_typeContract"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>

                </select>

                <label for="idDepartamentou" class="form-label fw-bold">Departamento</label>
                <select name="idDepartamentou" id="idDepartamentou" class="form-select">
                  <!-- Tu código PHP aquí -->
                  <?php
                  $sql = "SELECT id_departament, name_departament FROM tb_departament";
                  $stmt = $conn->query($sql);

                  // Generar las opciones del select
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_departament"] . '">' . $row["name_departament"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <label for="idJobTitleu" class="form-label fw-bold">Cargo</label>
                <select name="idJobTitleu" id="idJobTitleu" class="form-select">
                  <?php
                  $sql = "SELECT id_jobTitle, name_jobTitle FROM tb_jobTitle";
                  $stmt = $conn->query($sql);
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_jobTitle"] . '">' . $row["name_jobTitle"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();
                  ?>
                </select>

                <label for="fechaInicioLaboralu" class="form-label fw-bold">Fecha de Inicio Laboral</label>
                <input type="text" name="datesingleAdmin" id="fechaInicioLaboralu" class="form-control"
                  value="<?php echo date('Y-m-d'); ?>">

                <label for="cedulaEmpleadou" class="form-label fw-bold">Cédula de Empleado</label>
                <input type="text" name="cedulaInput" id="cedulaEmpleadou" class="form-control" maxlength="10">
              </div>
              <div class="col-md-6">
                <label for="nombreEmpleadou" class="form-label fw-bold">Nombre de Empleado</label>
                <input type="text" name="single-text" id="nombreEmpleadou" class="form-control">

                <label for="apellidoEmpleadou" class="form-label fw-bold">Apellido de Empleado</label>
                <input type="text" name="single-text" id="apellidoEmpleadou" class="form-control">

                <label for="telefonoEmpleadou" class="form-label fw-bold">Número de Teléfono</label>
                <input type="text" name="numeric" id="telefonoEmpleadou" class="form-control" maxlength="10">

                <label for="direccionEmpleadou" class="form-label fw-bold">Dirección</label>
                <input type="text" name="direccionEmpleadou" id="direccionEmpleadou" class="form-control">

                <label for="emailEmpleadou" class="form-label fw-bold">Email</label>
                <input type="text" name="email" id="emailEmpleadou" class="form-control">

                <label for="salaryu" class="form-label fw-bold">Remuneración</label>
                <input type="text" name="numeric" id="salaryu" class="form-control" maxlength="10" placeholder="$00.00">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success w-100" data-dismiss="modal"
              id="actualizadatos">Guardar</button>
          </div>
        </div>
      </div>
    </div>


  </section>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/functions.js"></script>
  <script src="assets/js/sessionLogout.js"></script>
  <script src="assets/js/validations.js"></script>

  <script>
    var titulo = "Gestión de Empleados";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;
  </script>

  <script>
    /* Llamando a la función getData() */
    getData();

    /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
    document.getElementById("campo").addEventListener("keyup", function () {
      document.getElementById("pagina").value = 1;
      getData();
    }, false)
    document.getElementById("num_registros").addEventListener("change", function () {
      document.getElementById("pagina").value = 1;
      getData();
    }, false)


    /* Peticion AJAX */
    function getData() {
      let input = document.getElementById("campo").value;
      let num_registros = document.getElementById("num_registros").value;
      let content = document.getElementById("content");
      let pagina = document.getElementById("pagina").value;
      let orderCol = document.getElementById("orderCol").value;
      let orderType = document.getElementById("orderType").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tableEmployees.php";
      let formaData = new FormData();
      formaData.append('campo', input);
      formaData.append('registros', num_registros);
      formaData.append('pagina', pagina);
      formaData.append('orderCol', orderCol);
      formaData.append('orderType', orderType);

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