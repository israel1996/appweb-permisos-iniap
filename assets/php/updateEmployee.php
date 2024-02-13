<?php
session_start();
require_once "database.php";
require_once "functions.php";


$response = array();

$idEmployee = $_POST['idEmployee'];
$idTipoCodigo = $_POST['idTipoCodigo'];
$idTipoContrato = $_POST['idTipoContrato'];
$idDepartamento = $_POST['idDepartamento'];
$idJobTitle = $_POST['idJobTitle'];
$idAbbrJob = $_POST['idAbbrJob'];
$cedulaEmpleado = $_POST['cedulaEmpleado'];
$nombreEmpleado = $_POST['nombreEmpleado'];
$apellidoEmpleado = $_POST['apellidoEmpleado'];
$dateInicioLaboral = $_POST['dateInicioLaboral'];
$telefonoEmpleado = $_POST['telefonoEmpleado'];
$direccionEmpleado = $_POST['direccionEmpleado'];
$emailEmpleado = $_POST['emailEmpleado'];
$salary = $_POST['salary'];
$isBoss = $_POST['isBoss'];
$isDirector = $_POST['isDirector'];
$isBoss = filter_var($isBoss, FILTER_VALIDATE_BOOLEAN);
$isDirector = filter_var($isDirector, FILTER_VALIDATE_BOOLEAN);


if (
  !empty($idTipoCodigo) && !empty($idTipoContrato)
  && !empty($idDepartamento) && !empty($idJobTitle) && !empty($idAbbrJob) && !empty($cedulaEmpleado) && !empty($nombreEmpleado)
  && !empty($apellidoEmpleado) && !empty($dateInicioLaboral) && !empty($telefonoEmpleado)
  && !empty($direccionEmpleado) && !empty($emailEmpleado) && !empty($salary)
) {


  if (validateCedula($cedulaEmpleado)) {

    $sql = 'CALL pa_updateEmployee(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, @p_success, @p_message)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
    $stmt->bindParam(2, $idTipoCodigo, PDO::PARAM_INT);
    $stmt->bindParam(3, $idTipoContrato, PDO::PARAM_INT);
    $stmt->bindParam(4, $idDepartamento, PDO::PARAM_INT);
    $stmt->bindParam(5, $idJobTitle, PDO::PARAM_INT);
    $stmt->bindParam(6, $idAbbrJob, PDO::PARAM_INT);
    $stmt->bindParam(7, $cedulaEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(8, $nombreEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(9, $apellidoEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(10, $dateInicioLaboral, PDO::PARAM_STR);
    $stmt->bindParam(11, $telefonoEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(12, $direccionEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(13, $emailEmpleado, PDO::PARAM_STR);
    $stmt->bindParam(14, $salary, PDO::PARAM_STR);
    $stmt->bindParam(15, $isBoss, PDO::PARAM_BOOL);
    $stmt->bindParam(16, $isDirector, PDO::PARAM_BOOL);

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
  $response['message'] = 'Verifique que estén todos los datos';
}

header('Content-Type: application/json');
echo json_encode($response);
?>