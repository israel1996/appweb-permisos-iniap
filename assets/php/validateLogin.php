<?php
session_start();

require_once "database.php";
require_once "../class/User.php";
require_once "../class/MenuItem.php";


$menu = array();

$response = array();
$recd_username = $_POST['username'];
$recd_pass = $_POST['password'];

//var_dump($recd_username);

if (!empty($recd_username) && !empty($recd_pass)) {

    $sql = 'CALL pa_validateUser(?, @p_success,@p_message, @p_employee_id, @p_user_id, @p_password_user)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $recd_username, PDO::PARAM_STR);

    $stmt->execute();

    $sql = 'SELECT @p_success AS success, @p_message AS message, @p_employee_id AS idEmployee, @p_user_id AS idUser, @p_password_user AS password';
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //Agrego el booleano y el mensaje 
    $response['success'] = $result['success'];
    $response['message'] = $result['message'];

    $idEmployee = $result['idEmployee'];
    $idUser = $result['idUser'];
    $pass = $result['password'];

    $stmt->closeCursor();


    if ($result['success'] && password_verify($recd_pass, $pass)) {

        $response['message'] = "Credenciales correctas";

        $sql1 = 'CALL pa_updateLastSession(?)';
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(1, $idUser, PDO::PARAM_INT);
        $stmt1->execute();
        $stmt1->closeCursor();

        $sql1 = 'CALL pa_getEmployeeDataByID(?)';
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(1, $idEmployee, PDO::PARAM_INT);

        $stmt1->execute();
        $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $stmt1->closeCursor();

        $sql2 = 'CALL pa_getUserDataByID(?)';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(1, $idUser, PDO::PARAM_INT);

        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $stmt2->closeCursor();

        // Crear un nuevo objeto User 
        $user = new User(
            $result1['id_employee'],
            $result2['id_user'],
            $result2['id_userType'],
            $result1['name_employee'],
            $result1['lastName_employee'],
            $result1['id_jobTitle'],
            $result1['id_departament'],
            $result1['isBoss_employee'],
            $result1['isDirector_employee']
        );

        // serializar el objeto User
        $_SESSION['user'] = serialize($user);

        //Construir url
        //$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = "http://" . $_SERVER['HTTP_HOST'];
        $nombreCarpeta = "/INIAP";
        $response['url'] = $url . $nombreCarpeta . "/index.php";
        ;

        //Generación de Objeto Menu
        //Administrador
        switch ($user->getIdUserType()) {
            case '1':
                $tab1 = new MenuItem('Inicio', $url . $nombreCarpeta . '/#');
                $menu[] = $tab1;

                $tab2 = new MenuItem('Empleados', '#');
                $menu[] = $tab2;

                $subTab1 = new MenuItem('Empleado', $url . $nombreCarpeta . '/admin_employee.php');
                $tab2->addSubmenu($subTab1);
                $subTab2 = new MenuItem('Usuario', $url . $nombreCarpeta . '/admin_user.php');
                $tab2->addSubmenu($subTab2);
                $subTab3 = new MenuItem('Periodos', $url . $nombreCarpeta . '/admin_periods.php');
                $tab2->addSubmenu($subTab3);


                $tab3 = new MenuItem('Permisos', '#');
                $menu[] = $tab3;

                $subTab4 = new MenuItem('Validación', $url . $nombreCarpeta . '/admin_permise.php');
                $tab3->addSubmenu($subTab4);
                $subTab5 = new MenuItem('Descuento', $url . $nombreCarpeta . '/admin_discount.php');
                $tab3->addSubmenu($subTab5);
                $subTab6 = new MenuItem('Vacaciones', $url . $nombreCarpeta . '/admin_vacation.php');
                $tab3->addSubmenu($subTab6);
                $subTab7 = new MenuItem('Atrasado', $url . $nombreCarpeta . '/admin_permissBack.php');
                $tab3->addSubmenu($subTab7);


                $tab4 = new MenuItem('Reportes', '#');
                $menu[] = $tab4;

                $subTab8 = new MenuItem('General', $url . $nombreCarpeta . '/admin_report_general.php');
                $tab4->addSubmenu($subTab8);
                $subTab9 = new MenuItem('Departamento', $url . $nombreCarpeta . '/admin_report_departament.php');
                $tab4->addSubmenu($subTab9);
                $subTab10 = new MenuItem('Empleado', $url . $nombreCarpeta . '/admin_report_employee.php');
                $tab4->addSubmenu($subTab10);
                $subTab11 = new MenuItem('Permisos', $url . $nombreCarpeta . '/admin_report_permiss.php');
                $tab4->addSubmenu($subTab11);


                $tab5 = new MenuItem('Sistema', '#');
                $menu[] = $tab5;

                $subTab12 = new MenuItem('Nueva Información', $url . $nombreCarpeta . '/admin_datamaster.php');
                $tab5->addSubmenu($subTab12);
                $subTab13 = new MenuItem('Logos de Aplicación', $url . $nombreCarpeta . '/admin_logos.php');
                $tab5->addSubmenu($subTab13);

                $_SESSION['menu'] = serialize($menu);


                break;

            case '2': //Empleado
                $tab1 = new MenuItem('Inicio', $url . $nombreCarpeta . '/index.php');
                $menu[] = $tab1;

                $tab2 = new MenuItem('Permisos', '#');
                $menu[] = $tab2;

                $subTab1 = new MenuItem('Solicitar', $url . $nombreCarpeta . '/employee_permise.php');
                $tab2->addSubmenu($subTab1);

                $subTab2 = new MenuItem('Saldos', $url . $nombreCarpeta . '/employee_balance.php');
                $tab2->addSubmenu($subTab2);

                if($user->getIsBossEmployee())
                {
                    $subTab3 = new MenuItem('Jefe - Autorizar', $url . $nombreCarpeta . '/boss_permise.php');
                    $tab2->addSubmenu($subTab3);
                }
                else if($user->getIsDirectorEmployee())
                {
                    $subTab4 = new MenuItem('Director - Autorizar', $url . $nombreCarpeta . '/director_permise.php');
                    $tab2->addSubmenu($subTab4);
                }


                $_SESSION['menu'] = serialize($menu);

               

                break;
            default:

                break;
        }

    } else {
        $response['success'] = false;
        $response['message'] = 'Credenciales incorrectas';
    }
} else {
    $response['message'] = 'Ingrese los datos';
}

header('Content-Type: application/json');
echo json_encode($response);
?>