<?php
include_once 'cabecalho.php';
?>

<?php
$aluno = filter_input(INPUT_GET, 'aluno');
$titulo = filter_input(INPUT_GET, 'titulo');
include_once '../class/Docente.php';
$d = new Docente();
$consulta = $d->consultar();
?>

<h3 class="mt-3"><!--como fizemos em consultar-->
    Adicionar membros na banca para o aluno<br><?= $aluno ?><br><!-- comment --><br>
    Título do trabalho: <?= $titulo ?>
</h3>


<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Área - Professor
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selprof" id="selprof" required>
                    <?php
                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>"><?= $mostrar[1] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>              

        <!-- Opção de dupla -->    

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <div class="campo">
            <label><strong>Add mais um docente? </strong></label>
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
                <div class="form-group row" id="seldupla">
                    <label for="inputText" class="col-sm-2 col-form-label" >            
                        Convidado - Selecione mais um docente
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" aria-label="Default select example" name="selprof2" id="selprof2" required>
                            <?php
                            foreach ($consulta as $mostrar) {
                                ?>
                                <option value="<?= $mostrar[0] ?>"><?= $mostrar[1] ?></option>
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
                    <a href="?p=bancaptg/montar" class="btn btn-danger">Voltar</a>
                </div>
                </form>
            </div>
        </div>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $vinculo = filter_input(INPUT_GET, 'vinculo');
    include_once '../class/BancaPTG.php';
    $b = new BancaPTG();
    $loop = 1;
    $selecao = filter_input(INPUT_POST, 'devweb', FILTER_SANITIZE_STRING);
    $professor1 = filter_input(INPUT_POST, 'selprof', FILTER_SANITIZE_NUMBER_INT);

    if ($selecao == "sim") {
        $professor2 = filter_input(INPUT_POST, 'selprof2', FILTER_SANITIZE_NUMBER_INT);
        $loop = 2;
    }
    $b->setVinculoPTG($vinculo);
    $b->editarSegundaEtapa();

    for ($i = 1; $i <= $loop; $i++) {
        $professor = $i == 1 ? $professor1 : $professor2;
        $tipoBanca = $i == 1 ? "área" : "convidado";
        $b->setTipoBanca($tipoBanca);
        $b->setProfessor($professor);
        $b->setVinculoPTG($vinculo);
        ?>
        <div class="alert alert-primary mt-3" role="alert" >
            <?= $b->salvarSegundaEtapa() ?>
        </div>
        
        <?php
    }
    
    echo '<meta http-equiv="refresh" CONTENT="0.1;URL=?p=bancaptg/montar">';
}


