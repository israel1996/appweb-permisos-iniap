<?php
session_start();
require_once "../assets/php/database.php";

$columns = [
    'id_permission',
    'id_employee',
    'id_reason',
    'fullname',
    'issueDate_permission',
    'state_permission',
    'workingDays_permission',
    'weekendDays_permission',
    'total',
    'observation_permission'
];

$table = "vw_permissVacation";
$id = 'id_permission';

$campo = isset($_POST['campo']) ? $_POST['campo'] : null;
$idEmployee = isset($_POST['idEmployee']) ? $_POST['idEmployee'] : null;

$where = '';
$params = [];

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE :campo$i OR ";
        $params[":campo$i"] = "%{$campo}%";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($where != '') {
    $where .= " AND id_reason = 4";
} else {
    $where = "WHERE id_reason = 4";
}

if ($idEmployee != null && $idEmployee != 0) {
    if ($where != '') {
        $where .= " AND id_employee = :idEmployee";
    } else {
        $where = "WHERE id_employee = :idEmployee";
    }
    $params[':idEmployee'] = $idEmployee;
}



$limit = isset($_POST['registros']) ? $_POST['registros'] : 10;
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$inicio = (int) $inicio;
$limit = (int) $limit;
$sLimit = "LIMIT $inicio, $limit";

//Ordenamiento
$sOrder = "";
if(isset($_POST['orderCol'])){
   $orderCol = $_POST['orderCol'];
   $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
   
   $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType;
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

// Actualizar el cálculo del total de registros y el total de páginas
$sqlTotal = "SELECT count($id) FROM $table $where";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->execute($params);
$totalRegistros = $stmtTotal->fetchColumn();

//Nombres de estados
$stateNames = [
    'P' => 'Pendiente',
    'R' => 'Rechazado',
    'V' => 'Validado'
];


$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';


if ($num_rows > 0) {
    foreach ($results as $row) {
        $datos = implode("||", $row);

        $output['data'] .= '<tr class="text-center">';
        $output['data'] .= '<td>' . $row['id_permission'] . '</td>';
        $output['data'] .= '<td>' . $row['fullname'] . '</td>';
        $output['data'] .= '<td>' . $row['issueDate_permission'] . '</td>';
        $output['data'] .= '<td>' . $stateNames[$row['state_permission']] . '</td>';
        $output['data'] .= '<td>' . $row['workingDays_permission'] . '</td>';
        $output['data'] .= '<td>' . $row['weekendDays_permission'] . '</td>';
        $output['data'] .= '<td>' . $row['total'] . '</td>';
        $output['data'] .= '<td>' . $row['observation_permission'] . '</td>';
        $output['data'] .= '<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPDFPermiss"
    onclick="generatePDFPermiss(\'' . $row['id_permission'] . '\')"><img src="./assets/icons/file-text.svg" alt="Ver"></button></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="9">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($totalRegistros / $limit);

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
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPageVacation(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>