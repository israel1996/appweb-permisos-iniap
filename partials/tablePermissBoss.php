<?php
session_start();
require_once "../assets/php/database.php";
require_once "../assets/class/User.php";

$columns = [
    'id_permission',
    'issueNumber_permission',
    'id_employee',
    'fullname',
    'name_reason',
    'issueDate_permission',
    'state_permission',
    'startDateTime_permission',
    'endDateTime_permission',
    'workingDays_permission',
    'weekendDays_permission',
    'total',
    'observation_permission'
];


$table = "vw_permissAdmin";
$id = 'id_permission';
$idEmployeeBoss = 0;
$idDepartament = 0;
$typeUser = 0;

$campo = isset($_POST['campo']) ? $_POST['campo'] : null;
$statePermiss = isset($_POST['statePermiss']) ? $_POST['statePermiss'] : null;

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $idEmployeeBoss = $user->getIdEmployee();
    $idDepartament = $user->getDepartamentEmployee();
    $typeUser = $user->getIdUserType();
}

$where = '';
$params = [];

if ($statePermiss != null) {
    $where = "WHERE state_permission = :statePermiss";
    $params[':statePermiss'] = $statePermiss;
}

// Condición para excluir el idEmployeeBoss
if ($idEmployeeBoss != 0) { // Asume que 0 es un valor no válido para un id real
    if ($where != "") {
        $where .= " AND ";
    } else {
        $where = "WHERE ";
    }
    $where .= "id_employee != :idEmployeeBoss";
    $params[':idEmployeeBoss'] = $idEmployeeBoss;
}


if ($idDepartament != 0 && $typeUser == 2) {
    if ($where != "") {
        $where .= " AND ";
    } else {
        $where = "WHERE ";
    }
    $where .= "id_departament = :idDepartament";
    $params[':idDepartament'] = $idDepartament;
}



//Busqueda
if ($campo != null) {
    if ($where != "") {
        $where .= " AND (";
    } else {
        $where = "WHERE (";
    }

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE :campo$i OR ";
        $params[":campo$i"] = "%{$campo}%";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


$limit = isset($_POST['registros']) ? $_POST['registros'] : 10;
$page = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

$start = ($page - 1) * $limit;

// Ordenamiento
$sOrder = "";
if (isset($_POST['orderCol'])) {
    $orderCol = $_POST['orderCol'];
    $orderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

    $sOrder = "ORDER BY " . $columns[intval($orderCol)] . ' ' . $orderType;
}

// Consulta
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " 
FROM $table 
$where
$sOrder
LIMIT $start, $limit";

$stmt = $conn->prepare($sql);
foreach ($params as $key => &$value) {
    $stmt->bindParam($key, $value);
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlTotal = "SELECT FOUND_ROWS()";
$stmtTotal = $conn->query($sqlTotal);
$total = $stmtTotal->fetchColumn();


// Razones
$sqlTemp = "SELECT id_reason, name_reason FROM tb_reason";
$stmt = $conn->query($sqlTemp);
$reasons = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reasons[$row['id_reason']] = $row['name_reason'];
}

// Nombres de estados
$stateNames = [
    'P' => 'Pendiente',
    'R' => 'Rechazado',
    'V' => 'Validado',
    'A' => 'Autorizado'
];


$output = [];
$output['totalRegistros'] = $total;
$output['data'] = '';
$output['paginacion'] = '';


foreach ($results as $row) {
    $output['data'] .= '<tr class="text-center">';
    $output['data'] .= '<td>' . $row['id_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['fullname'] . '</td>';
    $output['data'] .= '<td>' . $row['issueDate_permission'] . '</td>';
    $output['data'] .= '<td>' . $stateNames[$row['state_permission']] . '</td>';
    $output['data'] .= '<td>' . $row['startDateTime_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['endDateTime_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['workingDays_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['weekendDays_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['total'] . '</td>';
    $output['data'] .= '<td><button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetailPermiss"
     onclick="addToModalPermiss(\'' . implode("||", $row) . '\')"><img src="./assets/icons/check.svg" alt="Ver"></button></td>';
    $output['data'] .= '<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPDFPermiss"
    onclick="generatePDFPermiss(\'' . $row['id_permission'] . '\')"><img src="./assets/icons/file-text.svg" alt="Ver"></button></td>';
    $output['data'] .= '</tr>';
}


if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($total / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if (($page - 4) > 1) {
        $numeroInicio = $page - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if ($numeroFin > $totalPaginas) {
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($page == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPagePermiss(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>