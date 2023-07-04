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
<br><br>
<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <div class="d-flex align-items-center">
            <img src="./assets/icons/search.svg" alt="lupita" style="width: 24px; height: 24px;">
            <h5 class="ms-2">Buscador</h5>
        </div>

        <select id="buscadorvivo" class="form-select">
            <option value="0">Todos</option>
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
        $('#buscadorvivo').select2();

        $('#buscadorvivo').change(function () {
            $.ajax({
                type: "post",
                data: 'valor=' + $('#buscadorvivo').val(),
                url: './assets/php/createSessionSearch.php',
                success: function (r) {
                    $('#tabla').load('./partials/tableEmployees.php');

                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud Ajax
                    console.log("Error en la solicitud Ajax:", error);
                }
            });
        });
    });
</script>