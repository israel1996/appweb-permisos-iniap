<?php
session_start();
require_once "database.php";
require_once "../class/User.php";

$response = array();

$employeeUser = unserialize($_SESSION['user']);

$passwordNow = $_POST['passwordNow'];
$passwordNew = $_POST['passwordNew'];
$confirmPasswordNew = $_POST['confirmPasswordNew'];
$idUser = $employeeUser->getIdUser();

if (!empty($passwordNow) && !empty($passwordNew) && !empty($confirmPasswordNew)) {
    $sql = 'CALL pa_getPasswordUser(?, @p_password_user, @p_success)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'SELECT @p_password_user AS password, @p_success AS success';
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    $response['success'] = $result['success'];
    $pass = $result['password'];

    if ($result['success'] && password_verify($passwordNow, $pass)) {
        $sql = 'CALL pa_updatePasswordUser(?, ?, @p_success, @p_message)';
        $stmt = $conn->prepare($sql);
        $pass  = password_hash($confirmPasswordNew, PASSWORD_BCRYPT);
        $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
        $stmt->bindParam(2, $pass, PDO::PARAM_STR);
        $stmt->execute();

        $sql = 'SELECT @p_success AS success, @p_message AS message';
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $response['success'] = $result['success'];
        $response['message'] = $result['message'];
    } else {
        $response['success'] = false;
        $response['message'] = 'La clave actual no coincide';
    }

} else {
    $response['success'] = false;
    $response['message'] = 'Ingrese todos los datos';
}


header('Content-Type: application/json');
echo json_encode($response);
?>