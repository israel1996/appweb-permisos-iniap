<?php

require_once "../assets/php/database.php";

$sql = "SELECT id_departament, name_departament FROM tb_departament;";
$result = $conn->query($sql);
?>

<div class="row" style="margin-top: 5px;">
    <div class="col-sm-1">
        <img src="./assets/icons/search.svg" alt="lupita" style="width: 24px; height: 24px;">
    </div>
    <div class="col-sm-11">
        <select id="searchDepartamentReport" class="form-select">
            <option value="0">Seleccione o Escriba...</option>
            <?php while ($ver = $result->fetch(PDO::FETCH_NUM)): ?>
                <option value="<?php echo $ver[0] ?>">
                    <?php echo $ver[1] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#searchDepartamentReport').select2();

        $('#searchDepartamentReport').change(function () {
            document.getElementById("pagina").value = 1;
            getData();

        });
    });
</script>

