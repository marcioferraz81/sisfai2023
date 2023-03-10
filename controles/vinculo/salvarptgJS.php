<?php
include_once 'cabecalho.php';
?>

<h3 class="text-primary"><!--como fizemos em consultar-->
    Cadastrar Vinculo PTG (manual)
</h3>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form id="enviar">
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">
                Buscar por:
            </label>
            <div class="col-sm-10">
                <input type="text" name="campo" id="nome_docente">
            </div>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'campo')) {
    include_once '../class/VinculoPTG.php';
    $vinculoptg = new VinculoPTG();

    $campo = filter_input(INPUT_POST, 'campo');

    $vinculoptg->setProfessor($campo);

    $consultadoc = $vinculoptg->consultarProfessorLike();
    foreach ($consultadoc as $mostrar) {
        ?>
        <option id="resultado" value="<?=$mostrar[0]?>" <?=isset($id) && $matricula_prof == $mostrar[0] ? "selected" : ""?>><?=$mostrar[1]?></option>
        <?php
}
}
