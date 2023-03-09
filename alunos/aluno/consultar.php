<?php
include_once 'cabecalho.php';

include_once '../class/Curso.php';
$curso = new Curso();
$consulta = $curso->consultar();
?>

<h1 class="mt-3 text-primary">
    Pesquisar Alunos
    <a class="btn btn-primary float-right" href="?p=aluno/salvarSIGA">Carregar do SIGA</a>
    <a class="btn btn-link float-right mr-2" href="?p=aluno/salvar">Cadastro Manual</a>
</h1>
<div class="card shadow mb-4" style="background: #ffff99;">

    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <div class="col-sm-3">
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

            <div class="col-sm-3">
                <select class="form-control" aria-label="Default select example" name="selsemestre" id="selsemestre" required>
                    <option selected disabled>Semestre</option>
                    <option value="1">1º semestre</option>
                    <option value="2">2º semestre</option>            
                </select>
            </div>

            <div class="col-sm-4">
                <select class="form-control" aria-label="Default select example" name="selcurso" id="selcurso" required>
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

            <div class="col-sm-2">            
                <input type="submit" 
                       class="btn btn-primary"
                       name="btnpesquisar" 
                       value="Pesquisar">               
            </div>
        </div>

    </form>
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

    $dados = $al->pesquisar();

    if ($dados != false) {
        ?>

        <h3>
            <?= $semestre . "º semestre / " . $ano ?>
        </h3>
        <div class="card shadow mb-4">
            <!-- striped é para zebrar as linhas, cada uma com uma cor-->
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th>RA</th>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Ações</th>
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
                            <td><?= $mostrar[11] ?></td>
                            <td>
                                <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                <a href="?p=aluno/excluir&ra=<?= $mostrar[0] ?>" class="btn btn-danger" data-confirm="Excluir registro?" title="excluir">
                                    <i class="bi bi-trash-fill"></i>
                                </a>                        

                                <a href="?p=aluno/salvar&ra=<?= $mostrar[0] ?>" class="btn btn-primary ml-2" title="editar registro">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <!--foreach aqui END-->
                </tbody>
            </table>
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
                

