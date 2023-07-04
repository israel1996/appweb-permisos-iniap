<?php
function asignarObjetosASesion($array, $consulta, $sesion)
{
  include_once "database.php";

  $stmt = $conn->query($consulta);

  $objetos = array();

  if ($stmt->rowCount() > 0) {
    // Recorrer cada fila de resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // Crear un nuevo objeto utilizando los datos del array
      $objeto = new stdClass();
      foreach ($array as $value) {
        $objeto->{$value} = $row[$value];
      }
      $objetos[] = $objeto;
    }
  }
  $conn = null;

  session_start();
  $_SESSION[$sesion] = $objetos;
}

function validateCedula($cedula) {
  if(strlen($cedula) == 10) {
      $digito_region = substr($cedula, 0, 2);
      if($digito_region >= 1 && $digito_region <= 24) {
          $ultimo_digito = substr($cedula, 9);
          $pares = (int) $cedula[1] + (int) $cedula[3] + (int) $cedula[5] + (int) $cedula[7];
          $numero1 = (int) $cedula[0] * 2; if($numero1 > 9) { $numero1 -= 9; }
          $numero3 = (int) $cedula[2] * 2; if($numero3 > 9) { $numero3 -= 9; }
          $numero5 = (int) $cedula[4] * 2; if($numero5 > 9) { $numero5 -= 9; }
          $numero7 = (int) $cedula[6] * 2; if($numero7 > 9) { $numero7 -= 9; }
          $numero9 = (int) $cedula[8] * 2; if($numero9 > 9) { $numero9 -= 9; }
          $impares = $numero1 + $numero3 + $numero5 + $numero7 + $numero9;
          $suma_total = $pares + $impares;
          if($suma_total % 10 == 0) {
              $digito_validador = 0;
          } else {
              $digito_validador = 10 - ($suma_total % 10);
          }
          if($digito_validador == $ultimo_digito) {
              return true;
          } else {
              return false;
          }
      } else {
          return false;
      }
  } else {
      return false;
  }
}




?>