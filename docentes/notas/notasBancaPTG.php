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
$v = filter_input(INPUT_GET, 'vinculo');
$a = filter_input(INPUT_GET, 'aluno');
$nota = filter_input(INPUT_GET, 'nota');
include_once '../class/BancaPTG.php';
$b = new BancaPTG();
$b->setVinculoPTG($v);
$dados = $b->pesquisarNotasBancaPorVinculo();
?>
<div class="row">
    <div class="col-sm-12 col-md-10 ml-4">
        <h4>Aluno: <?= mb_strtoupper($a, 'UTF-8') ?></h4>

        <h5 style="color: red;">Nota do orientador: <?= number_format($nota, 2, ',', '.') ?>.</h5>


    </div>
    <div class="col-sm-12 col-md-1">
        <a href="?p=notas/listar" class="btn btn-danger mr-1" title="confirmar">
            <i class="bi bi-arrow-return-left"></i> Voltar
        </a>
    </div>
</div>

<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th style="width: 25%;">Professor</th>
                        <th>Tipo</th>
                        <th>Nota</th>
                        <th>Comentário</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->                
                <h3 class="m-3">Confira as notas atribuídas ao aluno</h3>                   
                <?php
                $media = 0;
                $cont = 0;
                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td class="text-left"><?= $mostrar[9] ?></td>
                        <td><?= $mostrar[3] ?></td>
                        <td><?= ($mostrar[4] == null OR empty($mostrar[4])) ? "-" : number_format($mostrar[4], 2, ',', '.') ?></td>
                        <td class="text-justify"><?= $mostrar[8] ?></td>
                    </tr>
                    <?php
                    $cont++;
                    $media = $media + $mostrar[4];
                }
                $final = (($media / $cont)) + $nota;
                ?>
                <!--foreach aqui END-->
                </tbody>
                <tfoot style="background: #66ccff; font-weight: bolder;" class="p-3 text-center">
                    <tr>
                        <td colspan="4" class="text-right">
                            Nota Final: <?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
