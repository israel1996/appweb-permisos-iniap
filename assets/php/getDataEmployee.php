<?php
session_start();
require_once "database.php";

$idEmployee = $_POST['id'];

$sql = "SELECT e.ci_employee,
e.name_employee,
e.lastName_employee,
d.name_departament,
e.startDate_employee
FROM tb_employee e 
INNER JOIN tb_departament d 
ON e.id_departament = d.id_departament
WHERE id_employee = :employeeId";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':employeeId', $idEmployee);
$stmt->execute(); 

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->closeCursor();

header('Content-Type: application/json');
echo json_encode($result);
?>
