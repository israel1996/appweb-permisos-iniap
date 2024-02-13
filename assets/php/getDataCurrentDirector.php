<?php
session_start();
require_once "database.php";

$idEmployee = $_POST['idEmployee'];
$isDirector = $_POST['isDirector'];
$isDirector = filter_var($isDirector, FILTER_VALIDATE_BOOLEAN);

$sql = 'CALL pa_searchCurrentDirector(?, ?, @p_success, @p_message)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->bindParam(2, $isDirector, PDO::PARAM_BOOL); // Cambiado a PDO::PARAM_INT

$stmt->execute();
$stmt->closeCursor(); // Cerrar el cursor si vas a hacer otra consulta después

// Realizar una consulta para obtener las variables de salida
$sql = "SELECT @p_success AS success, @p_message AS message";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);


header('Content-Type: application/json');
echo json_encode($resultado);
?>
