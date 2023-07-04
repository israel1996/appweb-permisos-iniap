<?php
session_start();
require_once "database.php";

$response = array();

$idEmployee = $_POST['idEmployee'];
$idReason = $_POST['idReason'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$observation = $_POST['observation'];

$sql = 'CALL pa_insertPermissionEmployee(?, ?, ?, ?, ?, @message, @success)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->bindParam(2, $idReason, PDO::PARAM_INT);
$stmt->bindParam(3, $startDate, PDO::PARAM_STR);
$stmt->bindParam(4, $endDate, PDO::PARAM_STR);
$stmt->bindParam(5, $observation, PDO::PARAM_STR);
$stmt->execute();

$stmt = $conn->query('SELECT @message AS message, @success AS success');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $result['success'];
$response['message'] = $result['message'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>