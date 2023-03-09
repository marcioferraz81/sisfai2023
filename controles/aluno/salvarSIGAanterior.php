<?php
include_once 'cabecalho.php';
?>

<?php
//estabelecer conversa com a class Categoria
include_once '../class/Curso.php';
$curso = new Curso();
$consulta = $curso->consultar();
?>

<h3 class="text-primary"><!--como fizemos em consultar-->
    Cadastrar alunos (planilha SIGA)
</h3>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Ano
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selano" id="selano" required>
                    <option selected disabled>Ano</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>                
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
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Curso
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selcurso" id="selcurso" required>
                    <option selected disabled>Escolha o curso</option>
                    <?php
                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>"><?= $mostrar[2] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">            
                Arquivo SIGA
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
            <a href="?p=aluno/consultar" class="btn btn-danger">Voltar</a>
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

    include_once '../class/Aluno.php';
    $al = new Aluno();

    if ($xlsx = $xls->parse($_FILES['arquivo']['tmp_name'])) {
        echo '<div class="container-fluid mt-2">';
        echo '<h3>Gravando XLSX</h3>';
        $i = 1;
        foreach ($xlsx->rows() as $mostrar) {
            if ($i > 2) {
                $al->setId_curso($curso);
                $al->setSemestre($ano . $semestre);
                $al->setRa($mostrar[0]);
                $al->setNome($mostrar[1]);
                $al->setEmail(NULL);
                $al->setFone(NULL);
                //$al->setTipo(NULL);
                ?>
                <div class="alert alert-primary" role="alert">
                    <?= $al->salvar() . " - " . "RA: $mostrar[0] | Nome: " . $mostrar[1] ?>
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

