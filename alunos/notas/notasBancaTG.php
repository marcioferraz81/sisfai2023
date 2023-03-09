<?php
include_once 'cabecalho.php';
?>


<?php

include_once '../class/BancaTG.php';
$b = new BancaTG();
$b->setVinculoTG($v);
$dados2 = $b->pesquisarNotasBancaPorVinculo();
?>
<div class="row">
    <div class="col-sm-12 col-md-10 ml-4">
        <h5 style="color: red;">Nota do orientador: <?= number_format($nota, 2, ',', '.') ?> (20% da nota final, ou seja, <?= number_format($nota * 0.2, 2, ',', '.') ?>).</h5>
        <p style="color: #999999;">Fórmula para cálculo: (Nota escrita * 0,4) + (Nota Oral * 0,3) + (Nota do Orientador * 0,2) + (Nota de formatação * 0,1)</p>
        <p style="color: #999999;">A nota do orientador e de formatação são atribuídas apenas pelo Prof. orientador</p>
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
                        <th>Nota Escrita</th>
                        <th>Nota Oral</th>
                        <th>Nota Formatação</th>

                        <th>Comentário</th>
                    </tr>
                </thead>
                <tbody class="text-center">  
                    <!--foreach aqui BEGIN-->                
                <h3 class="m-3">Confira as notas atribuídas ao aluno</h3>                   
                <?php
                $media = 0;
                $cont = 0;
                $escrita = 0;
                $oral = 0;
                foreach ($dados2 as $mostrar) {
                    ?>
                    <tr>
                        <td class="text-left"><?= $mostrar['docente'] ?></td>
                        <td><?= $mostrar[0] ?></td>

                        <td><?= $mostrar[4] != null OR empty(!$mostrar[4]) ? number_format($mostrar[6], 2, ',', '.') : "-" ?></td>
                        <td><?= number_format($mostrar[5], 2, ',', '.') ?></td>
                        <td><?= $mostrar[0] == 'orientador' ? number_format($mostrar[6], 2, ',', '.') : "-" ?></td>

                        <?php
                        /*
                          if ($mostrar[1] == null OR empty($mostrar[1])) {
                          echo "-";
                          } else {
                          echo "<td>" . number_format($mostrar[1], 2, ',', '.') . "</td>";
                          $cont++;
                          }
                         * 
                         */
                        $cont++;
                        ?>
                        <td class="text-justify"><?= $mostrar[2] ?></td>
                    </tr>
                    <?php
                    $media = $media + $mostrar[1];
                    $escrita = $escrita + $mostrar[4];
                    $oral = $oral + $mostrar[5];
                    $formatacao = $formatacao + ($mostrar[0] == 'orientador' ? $mostrar[6] : 0);
                }
                //$media = $media / $cont;
                @$oral = ($oral / $cont) * 0.3;
                @$escrita = ($escrita / $cont) * 0.4;
                @$formatacao = $formatacao * 0.1;

                @$final = $oral + $escrita + $formatacao + ($nota * 0.2);
                ?>                
                <!--foreach aqui END-->
                </tbody>
                <tfoot style="background: #66ccff; font-weight: bolder;" class="p-3 text-center">
                    <tr>
                        <td>Nota Final</td>
                        <td>-</td>
                        <td><?= ($escrita == null OR empty($escrita)) ? "-" : number_format($escrita, 2, ',', '.') ?></td>
                        <td><?= ($oral == null OR empty($oral)) ? "-" : number_format($oral, 2, ',', '.') ?></td>
                        <td><?= ($formatacao == null OR empty($formatacao)) ? "-" : number_format($formatacao, 2, ',', '.') ?></td>
                        <td><?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?></td>

                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
</div>
