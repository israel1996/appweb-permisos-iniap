<?php
session_start();
require_once __DIR__ . '/../class/User.php';

// Define constantes para los tipos de usuario
define("ADMIN", "1");
define("EMPLEADO", "2");

$type_user = "0";
$isBoss = false;

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
} else {
    $user = unserialize($_SESSION['user']);
    $type_user = $user->getIdUserType();
    $isBoss = $user->getIsBossEmployee();
    $isDirector = $user->getIsDirectorEmployee();

    // Regenera el ID de la sesión por seguridad
    session_regenerate_id();
}

$pages_user_can_access = array(
    ADMIN => array("admin_datamaster.php", "admin_discount.php", "admin_employee.php", "admin_periods.php", 
    "admin_permise.php", "admin_permissBack.php", "admin_user.php", "admin_vacation.php", "admin_logos.php", "admin_report_general.php", 
    "admin_report_permiss.php", "admin_report_departament.php", "admin_report_employee.php", "index.php"),
    EMPLEADO => array("employee_balance.php", "employee_permise.php", "index.php")
);

if ($isBoss && $type_user == 2) {
    $pages_user_can_access = array(
        EMPLEADO => array("employee_balance.php", "employee_permise.php", "boss_permise.php", "index.php")
    );
}
if ($isDirector && $type_user == 2) {
    $pages_user_can_access = array(
        EMPLEADO => array("employee_balance.php", "employee_permise.php", "director_permise.php", "index.php")
    );
}


// Obtiene la página actual
$current_page = basename($_SERVER['PHP_SELF']);

// Verifica si el usuario puede acceder a la página actual
if (!in_array($current_page, $pages_user_can_access[$type_user])) {
    // Redirige a la página de inicio con un mensaje de error
    $_SESSION["error_message"] = "No tienes permiso para acceder a esta página";
    header("Location: index.php");
    exit();
}
?>
