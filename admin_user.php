<?php
include 'assets/php/sessionChecker.php';
include_once "assets/php/database.php";

/*$userEmployee = '';




if (isset($_SESSION['user'])) {
  $inicioURL = "";
  $employeeUser = unserialize($_SESSION['user']);
  switch ($employeeUser->getIdUersType()) {
    case '1':
      header('#');
      break;
    case '2':
      header('#');
      break;
    default:

      break;
  }
} */

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

  <section class="container" style="margin-top: 70px;">
    <!-- Boton de Agregar, seleccionador de Registros y busqueda -->
    <div class="row g-4">
      <div class="col-auto">
        <div id="slotSearchEmployeeUser"></div>
      </div>
      <div class="col-2"></div>
      <div class="col-auto">
        <label for="num_registros" class="col-form-label fw-bold" style="margin-top: 50px;">Buscar: </label>
      </div>
      <div class="col-auto">
        <input type="text" name="campo" id="campo_user" class="form-control" placeholder="Escriba aquí..."
          style="margin-top: 50px;">
      </div>
      <div class="col-auto">
        <label for="num_registros_user" class="col-form-label fw-bold" style="margin-top: 50px;">Mostrar: </label>
      </div>
      <div class="col-auto">
        <select name="num_registros_user" id="num_registros_user" class="form-select" style="margin-top: 50px;">
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
              <th class="align-middle">ID Usuario</th>
              <th class="align-middle">Usuario</th>
              <th class="align-middle">Tipo de Usuario</th>
              <th class="align-middle">Nombres y Apellidos</th>
              <th class="align-middle">Estado</th>
              <th class="align-middle">Resetear</th>
              <th class="align-middle">Editar</th>
              <th class="align-middle">Eliminar</th>
            </tr> 
          </thead>
          <tbody id="content_user">
          </tbody>
        </table>
      </div>
      <!-- Paginacion -->
      <div class="row">
        <div class="col-5">
          <label id="lbl-total-user"></label>
        </div>
        <div class="col-7" id="nav-paginacion-user"></div>
        <input type="hidden" id="pagina_user" value="1">
        <input type="hidden" id="orderCol_user" value="0">
        <input type="hidden" id="orderType_user" value="desc">
      </div>
    </div>

    <!-- Modal para crear nuevo usuario-->
    <div class="modal fade" id="modalEmployeeUser" tabindex="-1" aria-labelledby="modalEmployeeUserLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEmployeeUserLabel">Nuevo Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="cedulaEmployeeUser" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeeUser" class="form-control" disabled>

                <label for="nameEmployeeUser" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeeUser" class="form-control" disabled>

                <label for="lastNameEmployeeUser" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeeUser" class="form-control" disabled>

              </div>

              <div class="col-md-6">

                <label for="departamentEmployeeUser" class="form-label fw-bold">Departamento</label>
                <input type="text" id="departamentEmployeeUser" class="form-control" disabled>

                <label for="idTypeUser" class="form-label fw-bold">Tipo de Usuario</label>
                <select name="idTypeUser" id="idTypeUser" class="form-select">
                  <?php
                  $sql = "SELECT id_userType, name_userType FROM tb_usertype";
                  $result = $conn->query($sql);

                  // Generar las opciones del select
                  if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_userType"] . '">' . $row["name_userType"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <div class="mb-3">
                  <label for="passwordUser" class="form-label fw-bold">Clave:</label>
                  <input type="password" class="form-control" id="passwordUser" placeholder="Ingresa tu clave...">
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="chPassDefault"
                    style="width: 20px; height: 20px; border: 2px solid #969696;">
                  <label class="form-check-label" for="chPassDefault"> Clave Predeterminada</label>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnEmployeeUser" class="btn btn-success w-100">Generar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para crear editar un usuario-->
    <div class="modal fade" id="modalEmployeeUseru" tabindex="-1" aria-labelledby="modalEmployeeUserLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEmployeeUserLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <input type="hidden" name="idUserSelected" id="idUserSelected" value="0">

                <label for="cedulaEmployeeUseru" class="form-label fw-bold">Cedula</label>
                <input type="text" id="cedulaEmployeeUseru" class="form-control" disabled>

                <label for="nameEmployeeUseru" class="form-label fw-bold">Nombres</label>
                <input type="text" id="nameEmployeeUseru" class="form-control" disabled>

                <label for="lastNameEmployeeUseru" class="form-label fw-bold">Apellidos</label>
                <input type="text" id="lastNameEmployeeUseru" class="form-control" disabled>

              </div>

              <div class="col-md-6">

                <label for="departamentEmployeeUseru" class="form-label fw-bold">Departamento</label>
                <input type="text" id="departamentEmployeeUseru" class="form-control" disabled>

                <label for="idTypeUseru" class="form-label fw-bold">Tipo de Usuario</label>
                <select name="idTypeUseru" id="idTypeUseru" class="form-select">
                  <?php
                  $sql = "SELECT id_userType, name_userType FROM tb_usertype";
                  $result = $conn->query($sql);

                  // Generar las opciones del select
                  if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option value="' . $row["id_userType"] . '">' . $row["name_userType"] . '</option>';
                    }
                  } else {
                    echo '<option value="">No hay datos disponibles</option>';
                  }
                  $result->closeCursor();

                  ?>
                </select>

                <div class="mb-3">
                  <label for="passwordUseru" class="form-label fw-bold">Clave:</label>
                  <input type="password" class="form-control" id="passwordUseru" placeholder="Ingresa tu clave...">
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnEmployeeUseru" class="btn btn-success w-100">Guardar Cambios</button>
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
    var titulo = "Gestión de Usuarios";
    document.getElementById("institucion").innerHTML = "<span>" + titulo.toUpperCase() + "</span>";
    document.title = titulo;


    var selectElement = document.getElementById("idTypeUser");
    selectElement.value = "3";

    var checkboxElement = document.getElementById("chPassDefault");
    checkboxElement.checked = true;


    var textInput = document.getElementById("passwordUser");
    textInput.disabled = true;


    checkboxElement.addEventListener("change", function () {
      if (checkboxElement.checked) {
        textInput.disabled = true;
      } else {
        textInput.disabled = false;
      }
    });


  </script>

  <script>
    /* Llamando a la función getDataUsers() */
    getDataUsers();

    /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getDataUsers. */
    document.getElementById("campo_user").addEventListener("keyup", function () {
      document.getElementById("pagina_user").value = 1;
      getDataUsers();
    }, false)
    document.getElementById("num_registros_user").addEventListener("change", function () {
      getDataUsers();
    }, false)


    /* Peticion AJAX */
    function getDataUsers() {
      let input = document.getElementById("campo_user").value;
      let num_registros = document.getElementById("num_registros_user").value;
      let content = document.getElementById("content_user");
      let pagina = document.getElementById("pagina_user").value;
      let orderCol = document.getElementById("orderCol_user").value;
      let orderType = document.getElementById("orderType_user").value;

      if (pagina == null) {
        pagina = 1;
      }

      let url = "./partials/tableUsers.php";
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
          document.getElementById("lbl-total-user").innerHTML = 'Mostrando ' + data.totalFiltro +
            ' de ' + data.totalRegistros + ' registros';
          document.getElementById("nav-paginacion-user").innerHTML = data.paginacion;
          //console.log(data.data);
        }).catch(err => console.log(err))
    }

    function nextPage(pagina) {
      document.getElementById('pagina_user').value = pagina;
      getDataUsers();
    }

    let columns = document.getElementsByClassName("sort");
    let tamanio = columns.length;
    for (let i = 0; i < tamanio; i++) {
      columns[i].addEventListener("click", ordenar);
    }

    function ordenar(e) {
      let elemento = e.target;

      document.getElementById('orderCol_user').value = elemento.cellIndex;

      if (elemento.classList.contains("asc")) {
        document.getElementById("orderType_user").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
      } else {
        document.getElementById("orderType_user").value = "desc"
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
      }

      getDataUsers();
    }

  </script>
</body>

</html>