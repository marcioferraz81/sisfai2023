
<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');
$professor = filter_input(INPUT_GET, 'professor');
$semestre = filter_input(INPUT_GET, 'semestre');

//estabelecer conversa com a class Categoria
include_once '../class/VinculoTG.php';
$vinculoptg = new VinculoTG();
//$consulta = $vinculoptg->consultar();

if (isset($ra)) {
    $vinculoptg->setAluno($ra);
    $vinculoptg->setProfessor($professor);
    $vinculoptg->setSemestre($semestre);
    $consulta = $vinculoptg->consultarPorID();
    foreach ($consulta as $mostrar) {
        $professor = $mostrar[0];
        $aluno = $mostrar[1];
        $semestre = substr($mostrar[2], -1);
        $ano = substr($mostrar[2], 0, -1);
        $dupla = $mostrar[3];
        $nome_aluno = $mostrar[5];
        $nome_dupla = $mostrar[6];
    }
}
?>
<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($ra) ? "Editar" : "Cadastrar" ?> Vinculo PTG
</h1>


<div class="card shadow mt-3 mb-4"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Aluno / Dupla
            </label>
            <div class="col-sm-10">
                <p><?= $nome_aluno . " / " . $nome_dupla ?></p>
            </div>
        </div>              
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Professor
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selprof" id="selprof" required>
                    <?php
                    $consultaDoc = $vinculoptg->consultarProfessor();
                    foreach ($consultaDoc as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>" <?= isset($professor) && $professor == $mostrar[0] ? "selected" : "" ?>><?= $mostrar[1] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>              

        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Ano / Semestre
            </label>
            <div class="col-sm-5">
                <select class="form-control" aria-label="Default select example" name="selano" id="selsemestre" required>
                    <option selected disabled>Ano</option>
                    <option value="2022" <?= $ano == 2022 ? "selected" : "" ?>>2022</option>
                    <option value="2023" <?= $ano == 2023 ? "selected" : "" ?>>2023</option>
                    <option value="2024" <?= $ano == 2024 ? "selected" : "" ?>>2024</option>
                    <option value="2025" <?= $ano == 2025 ? "selected" : "" ?>>2025</option>
                    <option value="2026" <?= $ano == 2026 ? "selected" : "" ?>>2026</option>
                    <option value="2027" <?= $ano == 2027 ? "selected" : "" ?>>2027</option>
                    <option value="2028" <?= $ano == 2028 ? "selected" : "" ?>>2028</option>
                    <option value="2029" <?= $ano == 2029 ? "selected" : "" ?>>2029</option>
                    <option value="2030" <?= $ano == 2030 ? "selected" : "" ?>>2030</option>

                </select>
            </div>
            <div class="col-sm-5">
                <select class="form-control" aria-label="Default select example" name="selsemestre" id="selsemestre" required>
                    <option selected disabled>Semestre</option>
                    <option value="1" <?= $semestre == 1 ? "selected" : "" ?>>1º semestre</option>
                    <option value="2" <?= $semestre == 2 ? "selected" : "" ?>>2º semestre</option>            
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn btn-success" 
                       name="btneditar" 
                       value="Editar">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=vinculotg/consultarptg" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    $anoNovo = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
    $professor = filter_input(INPUT_POST, 'selprof', FILTER_SANITIZE_NUMBER_INT);
    $semestreNovo = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);

    $vinculoptg->setProfessor($professor);
    $vinculoptg->setSemestre($anoNovo . $semestreNovo);

    $semestreAnterior = $ano . $semestre;
    ?>
    <div class="alert alert-primary mt-3" role="alert" >
        <?= $vinculoptg->editarVinculo($semestreAnterior) ?>
    </div>
    <?php
    echo $vinculoptg->getAluno() . " / " . $vinculoptg->getProfessor() . " / " . $vinculoptg->getSemestre();
}

