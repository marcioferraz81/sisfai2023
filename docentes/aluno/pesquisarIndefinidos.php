<?php
date_default_timezone_set('America/Sao_Paulo');
(!isset($_SESSION)) ? session_start() : "";
$nivel = 1; //0,1 ou 2

if ($_SESSION['acesso'] != '7a85f4764bbd6daf1c3545efbbf0f279a6dc0beb' OR $_SESSION['nivel'] < $nivel) {
    header("location:logout.php");
}
if (isset($_SESSION['start_login']) && (time() - $_SESSION['start_login'] > 600)) {
    header("location:logout.php");
}
$_SESSION['start_login'] = time();

include_once '../class/Curso.php';
$curso = new Curso();
$consulta = $curso->consultar();
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Pesquisar Alunos sem tg/ptg definido(s)
    </h1>
</div>

<div class="col-md-12 col-sm-12 mt-4">
    <div class="card shadow mb-4 col-md-12 col-sm-12 mt-4" style="background: #ffff99;">

        <form method="post" name="formsalvar" id="formSalvar" class="m-3 " enctype="multipart/form-data">
            <!-- m-3 determinei todas as bordas, não mudei o form-->        
            <div class="form-group row">
                <div class="col-sm-12 col-md-2">
                    <select class="form-control col-sm-12  mt-1" aria-label="Default select example" name="selano" id="selano" required>
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

                <div class="col-sm-12 col-md-2">
                    <select class="form-control col-sm-12 mt-1" aria-label="Default select example" name="selsemestre" id="selsemestre" required>
                        <option selected disabled>Semestre</option>
                        <option value="1">1º semestre</option>
                        <option value="2">2º semestre</option>            
                    </select>
                </div>

                <div class="col-sm-12 col-md-4">
                    <select class="form-control col-sm-12 mt-1" aria-label="Default select example" name="selcurso" id="selcurso" required>
                        <option selected disabled>Curso</option>
                        <?php
                        foreach ($consulta as $mostrar) {
                            ?>
                            <option value="<?= $mostrar[0] ?>"><?= $mostrar[2] ?></option>
                            
                            <?php
                            
                        }
                        ?>                
                    </select>
                </div>

                <div class="col-sm-12 col-md-2 mt-1">            
                    <input type="submit" 
                           class="btn btn-primary"
                           name="btnpesquisar" 
                           value="Pesquisar">               
                </div>
            </div>

        </form>
    </div>
</div>
<?php
if (filter_input(INPUT_POST, 'btnpesquisar')) {
    include_once '../class/Aluno.php';
    $al = new Aluno();

    $curso = filter_input(INPUT_POST, 'selcurso', FILTER_SANITIZE_NUMBER_INT);
    $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
    $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
    $al->setId_curso($curso);
    $al->setSemestre($ano . $semestre);

    $dados = $al->pesquisarIndefinidos();
    
    foreach ($dados as $mostrar) {
        $nomecurso = $mostrar[12];
    }

    if ($dados != false) {
        ?>

        <h3 class="text-center">
            <?= $semestre . "º semestre/" . $ano . " | PTG/TG indefinido(s) | " . $nomecurso ?>
        </h3>
        <div class="col-sm-12 mb-4">
            <div class="card shadow mb-4">
                <!-- striped é para zebrar as linhas, cada uma com uma cor-->
                <div class="table-responsive-sm mt-4">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>RA</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <!--foreach aqui BEGIN-->
                            <?php
                            //estabelecer conversa com a class Categoria

                            foreach ($dados as $mostrar) {
                                ?>
                                <tr>
                                    <td><?= $mostrar[0] ?></td>
                                    <td><?= $mostrar[4] ?></td>
                                    <td><?= $mostrar[2] ?></td>
                                    <td><?= $mostrar[3] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <!--foreach aqui END-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger mt-3" role="alert">
            Nenhum registro encontrado
        </div>
        <?php
    }
}
                

