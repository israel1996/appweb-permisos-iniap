<?php
session_start();
require_once "database.php";

$response = array();

$idPermissBack = $_POST['idPermissBack'];
$minDate = $_POST['minDate'];
$state = $_POST['state'];


$sql = 'CALL pa_updatePermissionBack(?, ?, ?, @message, @success)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idPermissBack, PDO::PARAM_INT);
$stmt->bindParam(2, $minDate, PDO::PARAM_STR);
$stmt->bindParam(3, $state, PDO::PARAM_BOOL);

$stmt->execute();

$stmt = $conn->query('SELECT @message AS message, @success AS success');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $result['success'];
$response['message'] = $result['message'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>