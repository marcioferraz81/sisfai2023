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
?>

<?php
$matricula = $_SESSION['matricula'];
include_once '../class/BancaPTG.php';
$b = new BancaPTG();
$b->setProfessor($matricula);
$dados = $b->pesquisarNotasBancaPorProfessor();
?>

<div class="col-sm-12 mt-4">
    <p>Legenda:</p>
    <i class="bi bi-list-ol"></i> listar notas da banca
</div>
<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <h3 class="m-3">Listar alunos PTG</h3>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <a href="?p=notas/listar" class="btn btn-danger" title="confirmar">
                            <i class="bi bi-list-ol"></i>
                        </a>
                    </div>
                </div>
                <?php
                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td><?= $mostrar[9] ?></td>
                        <td>
                            <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                            <a href="?p=notas/notasBancaPTG&vinculo=<?= $mostrar[1] ?>&aluno=<?= $mostrar[9] ?>" class="btn btn-primary" title="confirmar">
                                <i class="bi bi-list-ol"></i>
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
    </div>
</div>
