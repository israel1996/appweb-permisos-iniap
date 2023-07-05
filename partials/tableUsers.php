<?php
session_start();
require_once "../assets/php/database.php";
$columns = [
    'id_user',
    'id_employee',
    'ci_employee',
    'id_userType',
    'fullname',
    'name_user',
    'password_user',
    'state_user',
    'createdDate_user',
    'lastSession_user'
];

$table = "vw_users";
$id = 'id_user'; 

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


//Tipos de usuario
$sqlTemp = "SELECT id_userType, name_userType FROM tb_userType";
$stmt = $conn->query($sqlTemp);
$userTypes = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $userTypes[$row['id_userType']] = $row['name_userType'];
} 


$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';


if ($num_rows > 0) {

    foreach ($resultado as $row) {
        $idUser = $row['id_user'];
        $idEmployee = $row['id_employee'];
        $ciEmployee = $row['ci_employee'];
        $idUserType = $row['id_userType'];
        $fullname = $row['fullname'];
        $nameUser = $row['name_user'];
        $passwordUser = $row['password_user'];
        $stateUser = $row['state_user'];
        $createdDateUser = $row['createdDate_user'];
        $lastSessionUser = $row['lastSession_user'];

        $datosArray = [
            $idUser,
            $idEmployee,
            $ciEmployee,
            $idUserType,
            $fullname,
            $nameUser,
            $passwordUser,
            $stateUser,
            $createdDateUser,
            $lastSessionUser
        ];
        
        $datos = implode('||', $datosArray);

        $output['data'] .= '<tr class="text-center">';

        $output['data'] .= '<td>' . $idUser . '</td>';
        $output['data'] .= '<td>' . $nameUser . '</td>';
        $output['data'] .= '<td>' . $userTypes[$idUserType] . '</td>';
        $output['data'] .= '<td>' . $fullname . '</td>';

        $output['data'] .= '<td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEmployeeUseru" 
        onclick="addToModalUser(\'' . $datos . '\')">
        <img src="./assets/icons/edit-3.svg" alt="Editar">
        </button> </td>';
        
        $passEncryp = password_hash($ciEmployee, PASSWORD_BCRYPT);
        $output['data'] .= '<td><button class="btn btn-primary" onclick="preguntarSiNoReset(' . $idUser . ',\'' . $passEncryp . '\')">
        <img src="./assets/icons/key.svg" alt="Resetear">
        </button> </td>';
        
        if ($stateUser == 1) {
            $output['data'] .= '<td> <button class="btn btn-success" onclick="preguntarSiNo(' . $idUser . ')">
            <img src="./assets/icons/user.svg" alt="user">
            </button></td>';
        } else {
            $output['data'] .= '<td> <button class="btn btn-danger" onclick="yesOrNoQuestionEnableUser(' . $idUser . ')">
            <img src="./assets/icons/user-x.svg" alt="Enable">
            </button></td>';
        }

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