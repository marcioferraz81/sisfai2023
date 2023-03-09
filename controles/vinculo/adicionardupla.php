<?php
include_once 'cabecalho.php';
?>
<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');
$professor = filter_input(INPUT_GET, 'professor');
$semestre = filter_input(INPUT_GET, 'semestre');

//estabelecer conversa com a class Categoria
//$consulta = $vinculoptg->consultar();

if (isset($ra)) {
    include_once '../class/VinculoPTG.php';
    $vinculoptg = new VinculoPTG();
    $vinculoptg->setAluno($ra);
    $vinculoptg->setProfessor($professor);
    $vinculoptg->setSemestre($semestre);
    $consulta = $vinculoptg->consultarPorID();
    foreach ($consulta as $mostrar) {
        $nome_aluno = $mostrar[5];
    }
}
?>
<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    Adicionar dupla PTG
</h1>
<div class="card shadow mt-3 mb-4"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Aluno
            </label>
            <div class="col-sm-10">
                <p><?= $nome_aluno ?></p>
            </div>
        </div>          
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label" >            
                Selecione a Dupla
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="seldupla" id="seldupla" required>
                    <option value="NULL" selected disabled>Escolha a dupla</option>
                    <?php
                    include_once '../class/VinculoPTG.php';
                    $vinculoptg = new VinculoPTG();
                    $consulta = $vinculoptg->consultarAluno2();

                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>"><?= $mostrar[4] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn btn-primary" 
                       name="btnsalvar" 
                       value="Cadastrar">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=vinculo/consultarptg" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>


<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
//capturar id da url
    $ra = filter_input(INPUT_GET, 'ra');
    $professor = filter_input(INPUT_GET, 'professor');
    $semestre = filter_input(INPUT_GET, 'semestre');
    $dupla = filter_input(INPUT_POST, 'seldupla', FILTER_SANITIZE_NUMBER_INT);

    $vinculoptg->setAluno($ra);
    $vinculoptg->setProfessor($professor);
    $vinculoptg->setSemestre($semestre);
    $vinculoptg->setDupla($dupla);

    if ($vinculoptg->adicionardupla()) {
        ?>
        <div class="alert alert-primary" role="alert">
            Dupla adicionada com sucesso
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Erro ao adicionar
        </div>
        <?php
    }
    ?>
    <meta http-equiv="refresh" CONTENT="1;URL=?p=vinculo/consultarptg">
    <?php
}
?>
