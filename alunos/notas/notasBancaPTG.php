<?php
include_once 'cabecalho.php';
?>


<?php
include_once '../class/BancaPTG.php';
$b = new BancaPTG();
$b->setVinculoPTG($v);
$dados2 = $b->pesquisarNotasBancaPorVinculo();
?>
<div class="row">
    <div class="col-sm-12 col-md-10 ml-4">
        <h5 style="color: red;">Nota do orientador: <?= number_format($nota, 2, ',', '.') ?>.</h5>
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
                foreach ($dados2 as $mostrar) {
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
                $final = $cont != 0 ? (($media / $cont)) + $nota : 0;
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
