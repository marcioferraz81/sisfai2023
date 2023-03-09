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
include_once '../class/BancaTG.php';
$b = new BancaTG();
$b->setProfessor($matricula);
$dados = $b->listarGerarPDF();
?>

<div class="col-sm-12 mt-4">
    <p>Legenda:</p>
    <i class="bi bi-card-text"></i> gerar Declaração em PDF
</div>
<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped  table-sm">
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
                    echo "<h3 class='m-3'>Gerar declaração de TG</h3>";
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?= $mostrar[35] ?></td>
                            <td><?= mb_strtoupper($mostrar[3]) ?></td>
                            <td>
                                <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                <a href="?p=bancatg/gerarPDF&vinculo=<?= $mostrar[1] ?>" target="_blank" class="btn btn-primary" title="confirmar">
                                    <i class="bi bi-card-text"></i>
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
