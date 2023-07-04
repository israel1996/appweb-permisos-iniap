<?php
session_start();
require_once "database.php";

$response = array();

$idPermiss = $_POST['idPermiss'];
$state = $_POST['state'];
$message = $_POST['message'];

$sql = 'CALL pa_updatePermissionState(?, ?, ?, @message, @success)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idPermiss, PDO::PARAM_INT);
$stmt->bindParam(2, $state, PDO::PARAM_STR);
$stmt->bindParam(3, $message, PDO::PARAM_STR);

$stmt->execute();

$stmt = $conn->query('SELECT @message AS message, @success AS success');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $result['success'];
$response['message'] = $result['message'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>