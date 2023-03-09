<form>
    Buscar por: <input type="text" name="campo" id="campo">
</form>

<?php
include_once '../class/VinculoTG.php';
$vinculotg = new VinculoTG();

$campo = filter_input(INPUT_POST, 'campo', FILTER_SANITIZE_STRING) . "%";

$vinculotg->setProfessor($campo);

$consultadoc = $vinculotg->consultarProfessorLike();
foreach ($consultadoc as $mostrar) {
    ?>
    <option value="<?= $mostrar[0] ?>" <?= isset($id) && $matricula_prof == $mostrar[0] ? "selected" : "" ?>><?= $mostrar[1] ?></option>
    <?php
}
?>   
