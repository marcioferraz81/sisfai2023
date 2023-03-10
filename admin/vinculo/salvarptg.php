
<?php
include_once 'cabecalho.php';


?>

<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');

//estabelecer conversa com a class Categoria
include_once '../class/VinculoPTG.php';
$vinculoptg = new VinculoPTG();
//$consulta = $vinculoptg->consultar();

if (isset($ra)) {
    $vinculoptg->setAluno($ra);
    $consulta = $vinculoptg->consultarPorID();
    foreach ($consulta as $mostrar) {
        $professor = $mostrar[0];
        $aluno = $mostrar[1];
        $semestre = $mostrar[2];
        $dupla = $mostrar[3];
    }
}
?>
<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($ra) ? "Editar" : "Cadastrar" ?> Vínculo PTG
</h1>


<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Professor
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selprof" id="selprof" required>
                    <?php
                    //include_once '../class/VinculoPTG.php';
                    //$doc = new VinculoPTG();
                    $consulta = $vinculoptg->consultarProfessor();
                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>" <?= isset($id) && $matricula_prof == $mostrar[0] ? "selected" : "" ?>><?= $mostrar[1] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>              
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Aluno
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selaluno" id="selaluno" required>
                    <?php
                    include_once '../class/Curso.php';
                    $cu = new Curso();
                    $consultaAluno = $cu->cursoPesquisar();
                    foreach ($consultaAluno as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>" <?= isset($id) && $aluno == $mostrar[0] ? "selected" : "" ?>><?= $mostrar[4] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Semestre
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selsemestre" id="selsemestre" required>
                    <option selected disabled>Semestre</option>
                    <option value="1">1º semestre</option>
                    <option value="2">2º semestre</option>            
                </select>
            </div>
        </div>
        <!-- Opção de dupla -->    

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <div class="campo">
            <label><strong>Possui Dupla? </strong></label>
            <!-- removi o elemento "radio" que fato não existe -->
            <div>
                <input type="radio" name="devweb" id="sim" value="sim">
                <label for="sim">SIM</label>
            </div>
            <div>
                <input type="radio" name="devweb" id="nao" value="nao" checked>
                <label for="nao">NÃO</label>
            </div>
            <div>
                <script>
                    $(document).ready(function () {
                        $('#seldupla').hide();
                        // aqui um seletor por name, para pegar todos os radio buttons "devweb"
                        $('input:radio[name="devweb"]').change(function () {
                            // aqui, this é o radio quem foi clicado, então basta comparar o valor com val()
                            if ($(this).val() == "sim") {
                                $('#seldupla').show();
                            } else {
                                $('#seldupla').hide();
                            }
                        });
                    });
                </script>
                <div class="form-group row">
                    <label for="inputText" class="col-sm-2 col-form-label" >            
                        Selecione a Dupla
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" aria-label="Default select example" name="seldupla" id="seldupla" required>
                            <option value="NULL" selected>Sem dupla</option>
                            <?php
                            //include_once '../class/VinculoPTG.php';
                            //$doc = new VinculoPTG();
                            //$consulta = $vinculoptg->consultarAluno();

                            foreach ($consultaAluno as $mostrar) {
                                ?>
                                <option value="<?= $mostrar[0] ?>"><?= $mostrar[4] ?></option>
                                <?php
                            }
                            ?>                
                        </select>
                    </div></div>
                <!-- Opção de dupla (FIM) -->


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
        </div>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $ano = date('Y');
    $aluno = filter_input(INPUT_POST, 'selaluno', FILTER_SANITIZE_NUMBER_INT);
    $professor = filter_input(INPUT_POST, 'selprof', FILTER_SANITIZE_NUMBER_INT);
    $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
    $semestre = $semestre == "" ? (date('m') < 7 ? 1 : 2) : $semestre;
    $dupla = filter_input(INPUT_POST, 'seldupla', FILTER_SANITIZE_NUMBER_INT);

    include_once '../class/VinculoPTG.php';
    $ptg = new VinculoPTG();

    $ptg->setAluno($aluno);
    $ptg->setProfessor($professor);
    $ptg->setSemestre($ano . $semestre);
    $ptg->setDupla($dupla);
    ?>
    <div class="alert alert-primary mt-3" role="alert" >
        <?= $ptg->salvar() ?>
    </div>
    <?php
}

