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
include_once '../class/BancaPTG.php';
$b = new BancaPTG();
$b->setProfessor($matricula);
$dados = $b->pesquisarTerceiraEtapa();
?>

<div class="col-sm-12 mt-3">
    <p>Legenda:<br>
        <i class="bi bi-check2-circle"></i> conferir trabalho / atribuir nota<br><i class="bi bi-list-ol"></i> verificar notas dos membros da banca</p>
</div>
<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Aluno</th>

                        <th>Tipo banca</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    echo "<h3 class='m-3'>Atribuir notas de PTG</h3>";
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?= $mostrar[9] ?></td>

                            <td><?= mb_strtoupper($mostrar[3], 'UTF-8') ?></td>
                            <td>
                                <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                <a href="?p=notas/visualizarPTG&id=<?= $mostrar[0] ?>&vinculo=<?= $mostrar[1] ?>&aluno=<?= $mostrar[9] ?>&ra=<?= $mostrar['ra_aluno'] ?>" class="btn btn-primary" title="confirmar">
                                    <i class="bi bi-check2-circle"></i>
                                </a>  

                                <a href="?p=notas/notasBancaPTG&vinculo=<?= $mostrar[1] ?>&aluno=<?= $mostrar[9] ?>&nota=<?= $mostrar[12] ?>" class="btn btn-success" title="confirmar">
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
