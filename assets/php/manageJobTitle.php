<?php
session_start();
require_once "database.php";

$response = array();

$idJobTitle = $_POST['id'];
$nameJobTitle = $_POST['name'];
$operation = $_POST['operation'];

$sql = 'CALL pa_manageJobTitle(?, ?, ?, @p_success, @p_message)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idJobTitle, PDO::PARAM_INT);
$stmt->bindParam(2, $nameJobTitle, PDO::PARAM_STR);
$stmt->bindParam(3, $operation, PDO::PARAM_STR);
$stmt->execute();

$stmt = $conn->query('SELECT @p_success AS success, @p_message AS message');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $result['success'];
$response['message'] = $result['message'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>