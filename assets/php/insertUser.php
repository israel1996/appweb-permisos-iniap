<?php
session_start();
require_once "database.php";

$response = array();

$idEmployee = $_POST['idEmployee'];
$typeUser = $_POST['typeUser'];
$password = $_POST['password'];

$sql = 'CALL pa_insertUser(?,?,?, @p_success, @p_message)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
$stmt->bindParam(2, $typeUser, PDO::PARAM_INT);
$passwordEncrip = password_hash($password, PASSWORD_BCRYPT);
$stmt->bindParam(3, $passwordEncrip, PDO::PARAM_STR);

$stmt->execute();

$stmt = $conn->query('SELECT @p_success AS success, @p_message AS message');
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$response['success'] = $resultado['success'];
$response['message'] = $resultado['message'];

$stmt->closeCursor();


header('Content-Type: application/json');
echo json_encode($response);
?>