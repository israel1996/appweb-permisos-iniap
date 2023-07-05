<?php
session_start();
require_once "../assets/php/database.php";
$columns = [
    'id_employee',
    'id_codeType',
    'name_codeType',
    'id_typeContract',
    'name_typeContract',
    'id_departament',
    'name_departament',
    'id_jobTitle',
    'name_jobTitle',
    'ci_employee',
    'name_employee',
    'lastName_employee',
    'startDate_employee',
    'phoneNumber_employee',
    'address_employee',
    'email_employee',
    'salary_employee'
];

$table = "vw_Employees";
$id = 'id_employee'; 

$campo = isset($_POST['campo']) ? $_POST['campo'] : null;

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

$sOrder = "";
if (isset($_POST['orderCol'])) {
    $orderCol = $_POST['orderCol'];
    $orderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

    $sOrder = "ORDER BY {$columns[intval($orderCol)]} {$orderType}";
}

$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table
$where
$sOrder
$sLimit";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    foreach ($resultado as $row) {
        $idEmployee = $row['id_employee'];
        $idCodeType = $row['id_codeType'];
        $idTypeContract = $row['id_typeContract'];
        $idDepartament = $row['id_departament'];
        $idJobTitle = $row['id_jobTitle'];
        $ciEmployee = $row['ci_employee'];
        $nameEmployee = $row['name_employee'];
        $lastNameEmployee = $row['lastName_employee'];
        $startDateEmployee = $row['startDate_employee'];
        $phoneNumberEmployee = $row['phoneNumber_employee'];
        $addressEmployee = $row['address_employee'];
        $emailEmployee = $row['email_employee'];
        $salario = $row['salary_employee'];

        $datosArray = [
            $idEmployee,
            $idCodeType,
            $idTypeContract,
            $idDepartament,
            $idJobTitle,
            $ciEmployee,
            $nameEmployee,
            $lastNameEmployee,
            $startDateEmployee,
            $phoneNumberEmployee,
            $addressEmployee,
            $emailEmployee,
            $salario
        ];
        
        $datos = implode('||', $datosArray);

        $output['data'] .= '<tr class="text-center">';

        $output['data'] .= '<td>' . $idEmployee . '</td>';
        $output['data'] .= '<td>' . $ciEmployee . '</td>';
        $output['data'] .= '<td>' . $nameEmployee . '</td>';
        $output['data'] .= '<td>' . $lastNameEmployee . '</td>';
        $output['data'] .= '<td>' . $row['name_departament'] .'</td>';
        $output['data'] .= '<td>' . $row['name_codeType'] .'</td>';
        $output['data'] .= '<td>' . $row['name_jobTitle'] . '</td>';
        $output['data'] .= '<td>' . $startDateEmployee . '</td>';

        $output['data'] .= '<td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdicion" 
        onclick="agregaform(\'' . $datos . '\')">
        <img src="./assets/icons/edit-3.svg" alt="Editar">
        </button> </td>';

        $output['data'] .= '<td><button class="btn btn-danger" onclick="yesOrNoQuestionDisableEmployee(' . $idEmployee . ')">
        <img src="./assets/icons/user-x.svg" alt="Desactivar">
        </button></td>';

        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="9">Sin resultados</td>';
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
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
} 

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>