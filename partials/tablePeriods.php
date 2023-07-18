<?php
session_start();
require_once "../assets/php/database.php";

$columns = [
    'id_vacationPeriod',
    'id_employee',
    'full_name',
    'startDate_vacationPeriod',
    'endDate_vacationPeriod',
    'earnedWorkingDays_vacationPeriod',
    'earnedWeekendDays_vacationPeriod',
    'balanceWorkingDays_vacationPeriod',
    'balanceWeekendDays_vacationPeriod',
    'state_vacationPeriod'
];
$table = "view_vacationperiod";
$id = 'id_vacationPeriod';

$campo = isset($_POST['campo_period']) ? $_POST['campo_period'] : null;
$idEmployeeSelectedPeriod = isset($_POST['idEmployeeSelectedPeriod']) ? $_POST['idEmployeeSelectedPeriod'] : null;

$where = [];
$params = [];

//Busqueda
if ($campo != null) {
    $temp_where = [];
    for ($i = 0; $i < count($columns); $i++) {
        $temp_where[] = $columns[$i] . " LIKE :campo$i";
        $params[":campo$i"] = "%{$campo}%";
    }
    $where[] = "(" . implode(' OR ', $temp_where) . ")";
}

if ($idEmployeeSelectedPeriod != null && $idEmployeeSelectedPeriod != 0) {
    $where[] = "id_employee = :idEmployeeSelectedPeriod";
    $params[':idEmployeeSelectedPeriod'] = $idEmployeeSelectedPeriod;
} else {
    $where[] = "state_vacationPeriod = 1";
}

$where = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$limit = isset($_POST['registros_period']) ? $_POST['registros_period'] : 10;
$pagina = isset($_POST['pagina_period']) ? $_POST['pagina_period'] : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$inicio = (int)$inicio;
$limit = (int)$limit;
$sLimit = "LIMIT $inicio, $limit";

$sOrder = "";
if (isset($_POST['orderCol_period'])) {
    $orderCol = $_POST['orderCol_period'];
    $orderType = isset($_POST['orderType_period']) ? $_POST['orderType_period'] : 'asc';

    $allowedCols = $columns;
    $allowedOrderTypes = ['asc', 'desc'];
    if (in_array($orderCol, $allowedCols) && in_array(strtolower($orderType), $allowedOrderTypes)) {
        $sOrder = "ORDER BY $orderCol $orderType";
    }
}

$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " 
FROM $table 
$where
$sOrder
$sLimit";

$stmt = $conn->prepare($sql);
foreach ($params as $key => &$value) {
    $stmt->bindParam($key, $value);
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_rows = $stmt->rowCount();

$sqlFiltro = "SELECT FOUND_ROWS()";
$stmtFiltro = $conn->query($sqlFiltro);
$totalFiltro = $stmtFiltro->fetchColumn();

$sqlTotal = "SELECT count($id) FROM $table $where";
$stmtTotal = $conn->prepare($sqlTotal);
foreach ($params as $key => &$value) {
    $stmtTotal->bindParam($key, $value);
}
$stmtTotal->execute();
$totalRegistros = $stmtTotal->fetchColumn();

$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    foreach ($results as $row) {
        $datos = implode("||", $row);

        $earnedDays = $row['earnedWorkingDays_vacationPeriod'] + $row['earnedWeekendDays_vacationPeriod'];
        $balanceWorkingDays = $row['balanceWorkingDays_vacationPeriod'];
        $balanceWeekendDays = $row['balanceWeekendDays_vacationPeriod'];
        $balanceDays = $balanceWorkingDays + $balanceWeekendDays;
    
        $output['data'] .= '<tr class="text-center">';
        $output['data'] .= '<td>' . $row['id_vacationPeriod'] . '</td>';
        $output['data'] .= '<td>' . $row['full_name'] . '</td>';
        $output['data'] .= '<td>' . $row['startDate_vacationPeriod'] . '</td>';
        $output['data'] .= '<td>' . $row['endDate_vacationPeriod'] . '</td>';
        $output['data'] .= '<td>' . number_format($earnedDays, 2) . '</td>';
        $output['data'] .= '<td>' . $balanceWorkingDays . '</td>';
        $output['data'] .= '<td>' . $balanceWeekendDays . '</td>';
        $output['data'] .= '<td>' . number_format($balanceDays, 2) . '</td>';
        $output['data'] .= '<td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPeriodUpdate"
            onclick="addToModalPeriod(\'' . $datos . '\')"><img src="./assets/icons/edit-3.svg" alt="Ver"></button></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="9">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalFiltro'] > 0) {
    $totalPaginas = ceil($totalFiltro / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if (($pagina - 4) > 1) {
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if ($numeroFin > $totalPaginas) {
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPagePeriod(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>
