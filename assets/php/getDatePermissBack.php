<?php
session_start();
require_once "database.php";
require_once "../class/User.php";

$response = array();

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $idEmployee = $user->getIdEmployee();

    $sql = 'CALL pa_getPermissionBackDate(?, @p_date_permissionBack)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $idEmployee, PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $conn->query('SELECT @p_date_permissionBack AS permissionBack');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['date'] = $result['permissionBack'];

    $stmt->closeCursor();
} else {
    $response['date'] = date('Y-m-d H:i:s'); // La fecha y hora actual
}

header('Content-Type: application/json');
echo json_encode($response);
?>
