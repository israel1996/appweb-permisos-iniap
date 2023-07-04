<?php
session_start();
require_once "database.php";

$response = array();

$idEmployee = $_POST['id'];

$sql = 'CALL pa_disableUser(?, @p_success, @p_message)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->execute();

$stmt = $conn->query('SELECT @p_success AS success, @p_message AS message');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $result['success'];
$response['message'] = $result['message'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>