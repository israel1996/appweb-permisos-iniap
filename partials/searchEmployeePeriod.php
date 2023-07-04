<?php

require_once "../assets/php/database.php";

$sql = "SELECT
                        e.id_employee,
                        e.id_codeType,
                        e.id_typeContract,
                        e.id_departament,
                        e.ci_employee,
                        e.name_employee,
                        e.lastName_employee,
                        e.startDate_employee,
                        e.phoneNumber_employee,
                        e.address_employee,
                        e.email_employee
                        FROM
                        tb_employee e;";
$result = $conn->query($sql);
?>
<div class="row">
    <label class="form-label  fw-bold">Seleccionar Empleado</label>
</div>

<div class="row">
    <div class="col-sm-1">
        <img src="./assets/icons/search.svg" alt="lupita" style="width: 24px; height: 24px;">
    </div>
    <div class="col-sm-11">
        <select id="searchEmployeePeriod" class="form-select">
            <option value="0">Todos...</option>
            <?php while ($ver = $result->fetch(PDO::FETCH_NUM)): ?>
                <option value="<?php echo $ver[0] ?>">
                    <?php echo $ver[5] . " " . $ver[6] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#searchEmployeePeriod').select2();

        $('#searchEmployeePeriod').change(function () {
            var idEmployee = $(this).val();

            $('#idEmployeeSelectedPeriod').val(idEmployee);
            document.getElementById("pagina_period").value = 1;
            getDataPeriods();

        });
    });
</script>

