<?php
session_start();
require_once "../assets/php/database.php";

$columns = [
    'id_employee',
    'ci_employee',
    'fullname',
    'name_codeType',
    'balanceDays_vacationPeriod'
];

$table = "vw_reportGeneral";
$id = 'id_employee';

$campo = isset($_POST['campo']) ? $_POST['campo'] : null;

$where = '';
$params = [];

if (!is_null($campo)) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE :campo$i OR ";
        $params[":campo$i"] = "%{$campo}%";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

$limit = isset($_POST['registros']) ? (int) $_POST['registros'] : 10;
$pagina = isset($_POST['pagina']) ? (int) $_POST['pagina'] : 0;

if ($pagina === 0) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = $limit > 0 ? "LIMIT $inicio, $limit" : '';

$sOrder = "";
if (isset($_POST['orderCol']) && in_array($_POST['orderCol'], $columns)) {
    $orderCol = $_POST['orderCol'];
    $orderType = isset($_POST['orderType']) && in_array(strtolower($_POST['orderType']), ['asc', 'desc'])
        ? $_POST['orderType']
        : 'asc';

    $sOrder = "ORDER BY {$orderCol} {$orderType}";
}

try {
    $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
    FROM $table
    $where
    $sOrder
    $sLimit";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlFiltro = "SELECT FOUND_ROWS()";
    $stmtFiltro = $conn->query($sqlFiltro);
    $totalFiltro = $stmtFiltro->fetchColumn();

    $sqlTotal = "SELECT count($id) FROM $table";
    $stmtTotal = $conn->query($sqlTotal);
    $totalRegistros = $stmtTotal->fetchColumn();
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

$output = [
    'totalRegistros' => $totalRegistros,
    'totalFiltro' => $totalFiltro,
    'data' => '',
    'paginacion' => ''
];

foreach ($resultado as $row) {
    $output['data'] .= '<tr class="text-center">';

    $output['data'] .= '<td>' . $row['ci_employee'] . '</td>';
    $output['data'] .= '<td>' . $row['fullname'] . '</td>';
    $output['data'] .= '<td>' . $row['name_codeType'] . '</td>';
    $output['data'] .= '<td>' . $row['balanceDays_vacationPeriod'] . '</td>';

    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0 && $limit > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = (($pagina - 4) > 1) ? ($pagina - 4) : 1;
    $numeroFin = ($numeroInicio + 9 <= $totalPaginas) ? $numeroInicio + 9 : $totalPaginas;

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina === $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>