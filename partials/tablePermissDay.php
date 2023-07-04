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

$idEmployee = null;
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $idEmployee = $user->getIdEmployee();
}

$where = '';
$params = [];

if ($idEmployee != null) {
    if ($idEmployee != 0) {
        $where = "WHERE id_employee = :idEmployee";
        $params[':idEmployee'] = $idEmployee;
    }
}

$limit = isset($_POST['registros']) ? $_POST['registros'] : 10;
$page = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

$start = ($page - 1) * $limit;

//Ordenamiento
$sOrder = "";
if (isset($_POST['orderCol'])) {
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

    $sOrder = "ORDER BY " . $columns[intval($orderCol)] . ' ' . $oderType;
}

//Consulta
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


//Nombres de estados
$stateNames = [
    'P' => 'Pendiente',
    'R' => 'Rechazado',
    'V' => 'Validado'
];


$output = [];
$output['totalRegistros'] = $total;
$output['data'] = '';
$output['paginacion'] = '';


foreach ($results as $row) {
    $output['data'] .= '<tr class="text-center">';
    $output['data'] .= '<td>' . $row['issueDate_permission'] . '</td>';
    $output['data'] .= '<td>' . $stateNames[$row['state_permission']] . '</td>';
    $output['data'] .= '<td>' . $row['name_reason'] . '</td>';
    $output['data'] .= '<td>' . $row['workingDays_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['weekendDays_permission'] . '</td>';
    $output['data'] .= '<td>' . $row['total'] . '</td>';
    $output['data'] .= '<td>' . $row['observation_permission'] . '</td>';
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
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPageDiscountDate(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>