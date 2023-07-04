<?php
session_start();
require_once "database.php";

$idPeriod = $_POST['id'];

$sql = "SELECT e.ci_employee,
e.name_employee,
e.lastName_employee,
d.name_departament,
e.startDate_employee
FROM tb_employee e
JOIN tb_departament d ON e.id_departament = d.id_departament
JOIN tb_vacationperiod v ON v.id_employee = e.id_employee
WHERE v.id_vacationPeriod = :periodId";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':periodId', $idPeriod);
$stmt->execute(); 

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($result);
?>
