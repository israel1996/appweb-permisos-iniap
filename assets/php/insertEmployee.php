<?php
session_start();
require_once "database.php";
require_once "functions.php";

$response = array();

$idTipoCodigo = $_POST['idTipoCodigo'];
$idTipoContrato = $_POST['idTipoContrato'];
$idDepartamento = $_POST['idDepartamento'];
$idJobTitle = $_POST['idJobTitle'];
$cedulaEmpleado = $_POST['cedulaEmpleado'];
$nombreEmpleado = $_POST['nombreEmpleado'];
$apellidoEmpleado = $_POST['apellidoEmpleado'];
$dateInicioLaboral = $_POST['dateInicioLaboral'];
$telefonoEmpleado = $_POST['telefonoEmpleado'];
$direccionEmpleado = $_POST['direccionEmpleado'];
$emailEmpleado = $_POST['emailEmpleado'];
$salary = $_POST['salary'];



if (!empty($idTipoCodigo) && !empty($idTipoContrato)
  && !empty($idDepartamento) && !empty($idJobTitle) && !empty($cedulaEmpleado) && !empty($nombreEmpleado)
  && !empty($apellidoEmpleado) && !empty($dateInicioLaboral) && !empty($telefonoEmpleado)
  && !empty($direccionEmpleado) && !empty($emailEmpleado) && !empty($salary)
) {
  if (validateCedula($cedulaEmpleado)) {
    $sql = 'CALL pa_insertEmployee(?,?,?,?,?,?,?,?,?,?,?,?, @p_success, @p_message)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $idTipoCodigo, PDO::PARAM_INT);
    $stmt->bindParam(2, $idTipoContrato, PDO::PARAM_INT);
    $stmt->bindParam(3, $idDepartamento, PDO::PARAM_INT);
    $stmt->bindParam(4, $idJobTitle, PDO::PARAM_INT);
    $stmt->bindParam(5, $cedulaEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(6, $nombreEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(7, $apellidoEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(8, $dateInicioLaboral, PDO::PARAM_STR);
    $stmt->bindParam(9, $telefonoEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(10, $direccionEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(11, $emailEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(12, $salary, PDO::PARAM_STR);


    $stmt->execute();

    $stmt = $conn->query('SELECT @p_success AS success, @p_message AS message');
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['success'] = $resultado['success'];
    $response['message'] = $resultado['message'];

    $stmt->closeCursor();
  } else {
    $response['success'] = false;
    $response['message'] = 'El Número de cédula incorrecto';
  }

} else {
  $response['success'] = false;
  $response['message'] = 'Ingrese los datos';
}

header('Content-Type: application/json');
echo json_encode($response);
?>