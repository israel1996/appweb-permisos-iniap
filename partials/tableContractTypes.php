<?php
session_start();
require_once "../assets/php/database.php";

$columns = [
    'id_typecontract',
    'name_typecontract'
];
$table = "tb_typecontract";
$id = 'id_typecontract';

$campo = isset($_POST['campo_contractType']) ? $_POST['campo_contractType'] : null;

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

$limit = isset($_POST['registros_contractType']) ? $_POST['registros_contractType'] : 10;
$pagina = isset($_POST['pagina_contractType']) ? $_POST['pagina_contractType'] : 0;

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
if (isset($_POST['orderCol_contractType'])) {
    $orderCol = $_POST['orderCol_contractType'];
    $orderType = isset($_POST['orderType_contractType']) ? $_POST['orderType_contractType'] : 'asc';

    $allowedCols = ['id_typecontract', 'name_typecontract'];
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

$sqlTotal = "SELECT count($id) FROM $table";
$stmtTotal = $conn->query($sqlTotal);
$totalRegistros = $stmtTotal->fetchColumn();

$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    foreach ($results as $row) {
        $idContractType = $row['id_typecontract'];
        $nameContractType = $row['name_typecontract'];

        $datos = $idContractType . "||" . $nameContractType;

        $output['data'] .= '<tr class="text-center">';
        $output['data'] .= '<td>' . $idContractType . '</td>';
        $output['data'] .= '<td>' . $nameContractType . '</td>';
        $output['data'] .= '<td><button class="btn btn-warning" onclick="addToInputContractType(\'' . $datos . '\')"><img src="./assets/icons/edit-3.svg" alt="Editar"></button> </td>';
        $output['data'] .= '<td><button class="btn btn-danger" onclick="yesOrNoQuestionContractType(' . $idContractType . ')"><img src="./assets/icons/delete.svg" alt="Eliminar"></button></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="4">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

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
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPageContractType(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>
