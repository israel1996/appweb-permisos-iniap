<?php
session_start();
require_once "database.php";

$idEmployee = $_POST['idEmployee'];
$isBoss = $_POST['isBoss'];
$isBoss = filter_var($isBoss, FILTER_VALIDATE_BOOLEAN);

$sql = 'CALL pa_searchCurrentBoss(?, ?, @p_success, @p_fullname, @p_departament)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->bindParam(2, $isBoss, PDO::PARAM_BOOL); 

$stmt->execute();
$stmt->closeCursor(); // Cerrar el cursor si vas a hacer otra consulta después

// Realizar una consulta para obtener las variables de salida
$sql = "SELECT @p_success AS success, @p_fullname AS fullname, @p_departament AS departament";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


header('Content-Type: application/json');
echo json_encode($result);
?>
