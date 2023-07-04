<?php
require_once "./assets/class/User.php";
require_once "./assets/class/MenuItem.php";
require_once "./assets/php/dom.php";


?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0 m-0 fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="assets/images/Logo_blanco.png" alt="DBK Logo" height="72"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a id="institucion" class="navbar-brand" href="#">
        <span>Estación Experimental Tropical Pichilingue</span>
      </a>
      <?php

      if (isset($_SESSION['user'])) {
        // Datos del usuario actual
        $user = unserialize($_SESSION['user']);
        $nombres = $user->getNameEmployee();

        // Obtener el primer nombre y los dos apellidos
        $nombreSeparados = explode(' ', $nombres);
        $primerNombre = $nombreSeparados[0];

        $nombreUsuario = $primerNombre . ' ' . $user->getLastNameEmployee();
      } else {
        $nombreUsuario = '';
      }
      

      ?>

      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          <?php
          if (isset($_SESSION['menu'])) {
            $menu = unserialize($_SESSION['menu']);
            $menuHTML = generateMenuHTML($menu);
            echo $menuHTML;
          }

          ?>
          <?php
          if (isset($_SESSION['user'])) {
            echo '<li class="nav-item flare nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">' .
              $nombreUsuario . '
              </a>
              <ul class="dropdown-menu dropdown-menu-dark position-static text-center" aria-labelledby="navbarDropdownMenuLink">
                <li>
                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modalChangePassword" href="#">
                    <img src="assets/icons/key.svg" alt="Icono Cambiar Clave" style="margin-right: 10px;">Cambiar Clave
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="assets/php/logout.php">
                    <img src="assets/icons/log-out.svg" alt="Icono Cerrar Sesión" style="margin-right: 10px;">Cerrar Sesión
                  </a>
                </li>
              </ul>
            </li>';
          } else {
            echo '<li class="nav-item flare">
              <a class="nav-link mx-2" href="#">' .
              $nombreUsuario . '
              </a>
            </li>';
          }


          ?>
        </ul>
      </div>
    </div>
  </nav>



</header>

<!-- Modal para Cambiar Clave-->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalChangePasswordLabel">Cambio de clave</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="mb-3">
              <label for="passwordNow" class="form-label fw-bold">Clave Actual</label>
              <input type="password" id="passwordNow" class="form-control" placeholder="Escriba aqui...">
            </div>

            <div class="mb-3">
              <label for="passwordNew" class="form-label fw-bold">Nueva Clave</label>
              <input type="password" id="passwordNew" class="form-control" placeholder="Escriba aqui...">
            </div>

            <div class="mb-3">
              <label for="confirmPasswordNew" class="form-label fw-bold">Repetir Clave</label>
              <input type="password" id="confirmPasswordNew" class="form-control" placeholder="Escriba aqui...">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnChangePassword" class="btn btn-success w-100">Guardar</button>
      </div>
    </div>
  </div>
</div>