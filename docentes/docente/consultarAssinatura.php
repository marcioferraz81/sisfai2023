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
//include_once 'cabecalho.php';
include_once '../class/Assinatura.php';
$doc = new Assinatura();
$doc->setMatricula($_SESSION['matricula']);
$dados = $doc->consultarMatricula();
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Sua assinatura
        <a class="btn btn-primary float-right" href="?p=docente/salvarAssinatura">nova assinatura</a>
    </h1>
</div>

<div class="col-sm-12 mb-4">
    <div class="table-responsive-sm">
        <div class="card shadow">
            <!-- striped é para zebrar as linhas, cada uma com uma cor-->
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Docente</th>
                        <th>Assinatura</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    if ($dados != FALSE) {
                        foreach ($dados as $mostrar) {
                            ?>
                            <tr>
                                <td><?= $mostrar[1] ?></td>
                                <td><img src="../assinatura/<?= $mostrar[2] ?>" alt="assinatura" style="width: 100px;"></td>
                                <td>
                                    <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                    <a href="?p=docente/excluirAssinatura&matricula=<?= $mostrar[1] ?>" class="btn btn-danger ml-2 mb-1" data-confirm="Excluir registro?" title="excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>                        
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
