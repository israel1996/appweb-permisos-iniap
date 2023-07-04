<?php
session_start();
require_once "../assets/php/database.php";
require_once "../assets/class/Employee.php";
require_once "../assets/class/User.php";
if (isset($_SESSION['user'])) {
    $employeeUser = unserialize($_SESSION['user']);
    $idEmployee = $employeeUser->getEmployee()->getIdEmployee(); 
}

?>

<div class="row justify-content-center">
    <div class="col-12">
    <input type="text" hidden="" id="idEmployee" value="<?php echo $idEmployee; ?>" >
    
        <table class="table table-hover mt-4">
            <thead class="">
                <tr class="text-center">
                    <th class="align-middle">Fecha de Emisión</th>
                    <th class="align-middle">Estado</th>
                    <th class="align-middle">Motivo</th>
                    <th class="align-middle">Dias Laborales</th>
                    <th class="align-middle">Dias de Fin de Semana</th>
                    <th class="align-middle">Observación</th>
                    <th class="align-middle">Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_permission, 
                id_reason, 
                id_numberPeriod, 
                issueDate_permission, 
                state_permission,  
                startDateTime_permission,
                endDateTime_permission,
                workingDays_permission,
                weekendDays_permission,
                observation_permission,
                adminObservation_permission
                FROM tb_permission WHERE id_reason = 4;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                foreach ($results as $row) {
                    $idPermission = $row['id_permission'];
                    $idReason = $row['id_reason'];
                    $issueDatePermission = $row['issueDate_permission'];
                    $statePermission = $row['state_permission'];
                    $startDateTimePermission = $row['startDateTime_permission'];
                    $endDateTimePermission = $row['endDateTime_permission'];
                    $workingDaysPermission = $row['workingDays_permission'];
                    $weekendDaysPermission = $row['weekendDays_permission'];
                    $observationPermission = $row['observation_permission'];
                    $adminObservationPermission = $row['adminObservation_permission'];

                    $datos = $idPermission . "||" . 
                    $idReason . "||" . 
                    $issueDatePermission . "||" . 
                    $statePermission . "||" . 
                    $startDateTimePermission . "||" . 
                    $endDateTimePermission . "||" . 
                    $workingDaysPermission . "||" . 
                    $weekendDaysPermission . "||" . 
                    $observationPermission . "||" . 
                    $adminObservationPermission;

                    ?>

                    <tr class="text-center">
                        <td>
                            <?php echo $issueDatePermission ?>
                        </td>
                        <td>
                            <?php echo $statePermission ?>
                        </td>
                        <td>
                            <?php echo $idReason ?>
                        </td>
                        <td>
                            <?php echo $workingDaysPermission ?>
                        </td>
                        <td>
                            <?php echo $weekendDaysPermission ?>
                        </td>
                        <td>
                            <?php echo $observationPermission ?>
                        </td>
                        <td>
                            <button class="btn btn-success" onclick="generatePDFPermiss('<?php echo $idPermission ?>')">
                                <img src="./assets/icons/file-text.svg" alt="Ver">
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>