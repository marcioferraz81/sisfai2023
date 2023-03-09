<?php
include_once 'cabecalho.php';
?>
<h3 class="text-primary"><!--como fizemos em consultar-->
    Cadastrar docentes (planilha)<br>
    <p>Formato: matrícula, nome, status (0,1) e tipo (1,2)</p>
</h3>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form--> 
        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">            
                Arquivo XLSX
            </label>
            <div class="col-sm-10">
                <input type="file" name="arquivo" class="form-control" required>
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
            <a href="?p=docente/consultar" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
    $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
    $curso = filter_input(INPUT_POST, 'selcurso', FILTER_SANITIZE_NUMBER_INT);

    /** @noinspection ForgottenDebugOutputInspection */
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', true);

    include_once '../class/SimpleXLSX.php';
    $xls = new SimpleXLSX();

    include_once '../class/Docente.php';
    $d = new Docente();

    if ($xlsx = $xls->parse($_FILES['arquivo']['tmp_name'])) {
        echo '<div class="container-fluid mt-2">';
        echo '<h3>Gravando XLSX</h3>';
        $i = 1;
        foreach ($xlsx->rows() as $mostrar) {
            if ($i > 1) {
                $d->setMatricula($mostrar[0]);
                $d->setNome($mostrar[1]);
                $d->setStatus($mostrar[2]);
                $d->setTipo($mostrar[3]);
                $d->setHae($mostrar[4]);
                ?>
                <div class="alert alert-primary" role="alert">
                    <?= $d->salvar() . " - " . "Matrícula: $mostrar[0] | Nome: " . $mostrar[1] ?>
                </div>
                <?php
            }
            $i++;
        }
        echo '</div">';
    } else {
        echo SimpleXLSX::parseError();
    }
}

