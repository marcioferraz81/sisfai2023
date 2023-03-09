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

include_once '../class/Docente.php';
$d = new Docente();
$d->setMatricula($matricula);
$dadosD = $d->consultarPorID();
foreach ($dadosD as $mostrar) {
    $nome_professor = $mostrar[1];
}

include_once '../class/VinculoTG.php';
$c = new VinculoTG();
$dados = $c->consultarPorDocente($matricula);

include_once '../class/VinculoPTG.php';
$p = new VinculoPTG();
$dadosP = $p->consultarPorDocente($matricula);

include_once '../class/BancaPTG.php';
$b = new BancaPTG();
include_once '../class/BancaTG.php';
$bt = new BancaTG();
?>

<div class="col-sm-12">
    <h4>Bem vindo(a) Prof(a). <em><?= $nome_professor ?></em>, acompanhe abaixo seus alunos de PTG e TG.</h4>
</div>

<div class="col-sm-12 mt-4">
    <p>Legenda:</p>
    <i class="bi bi-check2-circle"></i> atribuir nota | <i class="bi bi-arrow-right-short"></i> encaminhar para banca
</div>
<div class="col-sm-12 mt-4">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th>Semestre</th>
                        <th>Aluno</th>
                        <th>Dupla</th>
                        <th>Nota Orientador</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    //estabelecer conversa com a class Categoria

                    echo "<h3 class='m-3'>Alunos PTG</h3>";
                    if (empty($dadosP)) {
                        ?>
                        <tr>
                            <td colspan="5" style="color: red; font-weight: bold;">Você não possui (neste semestre) alunos com PTG.</td>
                        </tr>
                        <?php
                    } else {
                        foreach ($dadosP as $mostrar) {
                            ?>
                            <tr>
                                <td><?= $mostrar[2] ?></td>
                                <td><?= $mostrar[5] ?></td>
                                <td><?= $mostrar[6] ?></td>
                                <td><?= number_format($mostrar[7], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $b->setVinculoPTG($mostrar[8]);
                                    //if ($b->pesquisarPrimeiraEtapa() == 0) {
                                    ?>
                                    <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                    <a href="?p=verificacao&tipo=ptg&aluno=<?= $mostrar[1] ?>&nome=<?= $mostrar[5] ?>" class="btn btn-primary ml-2" title="confirmar">
                                        <i class="bi bi-check2-circle"></i>
                                    </a> 
                                    <?php
                                    if ($b->pesquisarPrimeiraEtapa() == 0) {
                                        if ($mostrar[7] != null) {
                                            //if ($mostrar[7] >= 2.1) {
                                            ?>
                                            <a href="?p=bancaptg/encaminhar&professor=<?= $mostrar[0] ?>&id=<?= $mostrar[8] ?>" class="btn btn-success ml-2"  title="encaminhar" >
                                                <i class="bi bi-arrow-right-short"></i>
                                            </a>

                                            <?php
                                        }
                                    }
                                    //}
                                    // } else {
                                    //echo '<span class="badge badge-danger mt-1 mb-1 p-2">etapa finalizada</span>';
                                    echo '<a href="?p=notas/listar" class="btn btn-danger mt-1 mb-1 p-2" title="finalizar">Notas</a>';
                                    //}
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <!--foreach aqui END-->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-sm-12 mt-4">
    <p>Legenda:</p>
    <i class="bi bi-check2-circle"></i> atribuir nota | <i class="bi bi-arrow-right-short"></i> encaminhar para banca 
</div>
<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th>Semestre</th>
                        <th>Aluno</th>
                        <th>Dupla</th>
                        <th>Nota Orientador</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    //estabelecer conversa com a class Categoria

                    echo "<h3 class='m-3'>Alunos TG</h3>";
                    if (empty($dados)) {
                        ?>
                        <tr>
                            <td colspan="5" style="color: red; font-weight: bold;">Você não possui (neste semestre) alunos com TG.</td>
                        </tr>
                        <?php
                    } else {
                        foreach ($dados as $mostrar) {
                            ?>
                            <tr>
                                <td><?= $mostrar[2] ?></td>
                                <td><?= $mostrar[5] ?></td>
                                <td><?= $mostrar[6] ?></td>
                                <td><?= number_format($mostrar[7], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $bt->setVinculoTG($mostrar[8]);
                                    //if ($bt->pesquisarPrimeiraEtapa() == 0) {
                                    ?>
                                    <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                    <a href="?p=verificacao&tipo=tg&aluno=<?= $mostrar[1] ?>&nome=<?= $mostrar[5] ?>" class="btn btn-primary ml-2" title="confirmar">
                                        <i class="bi bi-check2-circle"></i>
                                    </a>                        
                                    <?php
                                    if ($bt->pesquisarPrimeiraEtapa() == 0) {
                                        if ($mostrar[7] != null) {
                                            //if ($mostrar[7] >= 7) {
                                            ?>
                                            <a href="?p=bancatg/encaminhar&professor=<?= $mostrar[0] ?>&id=<?= $mostrar[8] ?>" class="btn btn-success ml-2" title="encaminhar" >
                                                <i class="bi bi-arrow-right-short"></i>
                                            </a>
                                            <!-- Modal -->

                                            <?php
                                        }
                                    }
                                    //}
                                    //} else {
                                    //echo '<span class="badge badge-danger mt-1 mb-1 p-2">etapa finalizada.</span>';
                                    echo '<a href="?p=notas/listar" class="btn btn-danger mt-1 mb-1 p-2" title="finalizar">Notas</a>';
                                    //}
                                    ?>                       
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <!--foreach aqui END-->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="encaminhar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Encaminhar.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja encaminhar <?= $mostrar[5] ?> para banca?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="#<?= $mostrar[1] ?>" class="btn btn-primary">Encaminhar</a>
            </div>
        </div>
    </div>
</div>  

<script>
    $("#btn-mensagem<?= $mostrar[2] ?>").click(function () {
        $("#encaminhar<?= $mostrar[2] ?>").modal();
    });
</script>