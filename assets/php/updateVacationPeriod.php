<?php
session_start();
require_once "database.php";

$response = array();

$idPeriod = $_POST['idPeriod'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$earndDays = $_POST['earndDays'];
$balanceDays = $_POST['balanceDays'];
$workingDays = $_POST['workingDays'];
$weekendDays = $_POST['weekendDays'];
$staetPeriod = $_POST['statePeriod'];


$sql = 'CALL pa_updateVacationPeriod(?, ?, ?, ?, ?, ?, ?, ?, @p_message, @p_success)';
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $idPeriod, PDO::PARAM_INT);
$stmt->bindParam(2, $startDate, PDO::PARAM_STR);
$stmt->bindParam(3, $endDate, PDO::PARAM_STR);
$stmt->bindParam(4, $earndDays, PDO::PARAM_INT);
$stmt->bindParam(5, $balanceDays, PDO::PARAM_INT);
$stmt->bindParam(6, $workingDays, PDO::PARAM_INT);
$stmt->bindParam(7, $weekendDays, PDO::PARAM_INT);
$stmt->bindParam(8, $staetPeriod, PDO::PARAM_BOOL);
$stmt->execute();

$stmt = $conn->query('SELECT @p_message AS message, @p_success AS success');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$response['message'] = $result['message'];
$response['success'] = $result['success'];

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($response);
?>