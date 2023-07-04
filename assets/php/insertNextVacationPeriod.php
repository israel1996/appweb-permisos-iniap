<?php
session_start();
require_once "database.php";

$response = array();

$idEmployee = $_POST['id'];

$sql = 'CALL pa_nextVacationPeriod(?, @p_message, @p_success)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->execute();

$stmt = $conn->query('SELECT @p_message AS message, @p_success AS success');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['message'] = $result['message'];
$response['success'] = $result['success'];

$stmt->closeCursor(); 

header('Content-Type: application/json');
echo json_encode($response);
?>