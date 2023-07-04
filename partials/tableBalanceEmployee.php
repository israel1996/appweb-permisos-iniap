<?php
session_start();
require_once "../assets/php/database.php";
require_once "../assets/class/User.php";
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $idEmployee = $user->getIdEmployee(); 
}

?>

<div class="row justify-content-center">
    <div class="col-12">
    <input type="text" hidden="" id="idEmployee" value="<?php echo $idEmployee; ?>" >
    
        <table class="table table-hover mt-5">
            <thead class="">
                <tr class="text-center">
                    <th class="align-middle">Fecha de Inicio</th>
                    <th class="align-middle">Fecha de Fin</th>
                    <th class="align-middle">Dias Laborables</th>
                    <th class="align-middle">Dias de Fin de Semana</th>
                    <th class="align-middle">Saldo Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT 
                startDate_vacationPeriod,
                endDate_vacationPeriod,
                balanceWorkingDays_vacationPeriod,
                balanceWeekendDays_vacationPeriod,
                balanceDays_vacationPeriod
                FROM tb_vacationperiod
                WHERE state_vacationPeriod = 1 AND id_employee = " . $idEmployee;
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                foreach ($results as $row) {
                    $startDate = $row['startDate_vacationPeriod'];
                    $endDate = $row['endDate_vacationPeriod'];
                    $balanceWorkingDays = $row['balanceWorkingDays_vacationPeriod'];
                    $balanceWeekendDays = $row['balanceWeekendDays_vacationPeriod'];
                    $balanceDays = $row['balanceDays_vacationPeriod'];

                    $datos = $startDate . "||" . 
                    $endDate . "||" . 
                    $balanceWorkingDays . "||" . 
                    $balanceWeekendDays . "||" . 
                    $balanceDays;

                    ?>

                    <tr class="text-center">
                        <td>
                            <?php echo $startDate ?>
                        </td>
                        <td>
                            <?php echo $endDate ?>
                        </td>
                        <td>
                            <?php echo $balanceWorkingDays ?>
                        </td>
                        <td>
                            <?php echo $balanceWeekendDays ?>
                        </td>
                        <td>
                            <?php echo $balanceDays ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>