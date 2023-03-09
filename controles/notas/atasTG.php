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

$semestre = filter_input(INPUT_GET, 'semestre');

include_once '../class/VinculoTG.php';
include_once '../class/BancaTG.php';
$c = new VinculoTG();
$dados = $c->consultar2($_SESSION['curso'], $semestre);

foreach ($dados as $mostrar) {
    $b = new BancaTG();
    $b->setVinculoTG($mostrar['vinculo']);
    $dados2 = $b->pesquisarNotasBancaPorVinculo();
    $dados3 = $b->pesquisarNotasBancaPorVinculo();

    $media = 0;
    $cont = 0;
    $escrita = 0;
    $oral = 0;
    $formatacao = 0;

    include_once '../class/Assinatura.php';
    $ass = new Assinatura();
    if ($mostrar['nota'] != 0 || !empty($mostrar['nota']) || $mostrar['nota'] != null) {
        ?>

        <div class="row text-right">
            <div class="col-sm-12 col-md-12 text-justify">
                <h3 class="text-center">ATA<br><?= substr($semestre, -1) ?>º Semestre - <?= substr($semestre, 0, 4) ?></h3>
                <p>Indaiatuba, <?= date('d/m/Y') ?></p>
                <p class="text-justify">Aos <?= utf8_encode(strftime('%d de %B de %Y', strtotime(date('Y-m-d')))) ?>, na sala de Coordenação da Faculdade de Tecnologia de Indaiatuba – Rua Dom Pedro I, 65 - Cidade Nova I, Indaiatuba/SP, foi realizada uma reunião entre coordenador de curso e o aluno <?= mb_strtoupper($mostrar[5], 'UTF-8') ?><?= ($mostrar[6] != null || !empty($mostrar[6])) ? " e a dupla" . mb_strtoupper($mostrar[6], 'UTF-8') : "" ?>, com objetivo de documentar as notas atribuídas ao trabalho de TG.</p>

                <h5 style="color: red;">Nota do orientador: <?= number_format($mostrar['nota'], 2, ',', '.') ?> (20% da nota final, ou seja, <?= number_format($nota * 0.2, 2, ',', '.') ?>).</h5>
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
                                <th>Nota</th>
                                <th>Comentário</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <!--foreach aqui BEGIN-->                
                        <h3 class="m-3">Confira as notas atribuídas ao aluno</h3>                   
                        <?php
                        $media3 = 0;
                        $cont3 = 0;
                        $escrita3 = 0;
                        $oral3 = 0;
                        $formatacao3 = 0;
                        foreach ($dados3 as $mostrar3) {
                            ?>
                            <tr>
                                <td class="text-left"><?= $mostrar3[3] ?></td>
                                <td><?= $mostrar3[0] ?></td>

                                <td><?= number_format($mostrar3[4], 2, ',', '.') ?></td>
                                <td><?= number_format($mostrar3[5], 2, ',', '.') ?></td>
                                <td><?= $mostrar3[0] == 'orientador' ? number_format($mostrar3[6], 2, ',', '.') : "-" ?></td>
                                <td class="text-justify"><?= $mostrar3[2] ?></td>
                            </tr>
                            <?php
                            $cont3++;
                            $media3 = $media3 + ($mostrar3[4] == null ? 0 : $mostrar3[4]);
                            $escrita3 = $escrita3 + ($mostrar3[4] == null ? 0 : $mostrar3[4]);
                            $oral3 = $oral3 + ($mostrar3[5] == null ? 0 : $mostrar3[5]);
                            $formatacao3 = $formatacao3 + ($mostrar3[0] == 'orientador' ? $mostrar3[6] : 0);

                            switch ($mostrar3[0]) {
                                case 'orientador':
                                    $orientador = $mostrar3[3];
                                    $mat_orientador = $mostrar3['mat'];
                                    break;
                                case 'área':
                                    $area = $mostrar3[3];
                                    $mat_area = $mostrar3['mat'];
                                    break;
                                case 'convidado':
                                    $convidado = $mostrar3[3];
                                    $mat_convidado = $mostrar3['mat'];
                                    break;
                            }
                        }
                        $oral3 = ($oral3 == 0 ? 0 : ($oral3 / $cont3) * 0.3);
                        $escrita3 = ($escrita3 == 0 ? 0 : ($escrita3 / $cont3) * 0.4);
                        $formatacao3 = ($formatacao3 == 0 ? 0 : $formatacao3 * 0.1);

                        $final3 = $oral3 + $escrita3 + $formatacao3 + ($mostrar['nota'] * 0.2);
                        ?>
                        <!--foreach aqui END-->
                        </tbody>
                        <tfoot >
                            <tr  style="background: #66ccff; font-weight: bolder;" class="p-3 text-center">
                                <td>Nota Final</td>
                                <td>-</td>
                                <td><?= ($escrita3 == null OR empty($escrita3)) ? "-" : number_format($escrita3, 2, ',', '.') ?></td>
                                <td><?= ($oral3 == null OR empty($oral3)) ? "-" : number_format($oral3, 2, ',', '.') ?></td>
                                <td><?= ($formatacao3 == null OR empty($formatacao3)) ? "-" : number_format($formatacao3, 2, ',', '.') ?></td>
                                <td><?= ($final3 == null OR empty($final3)) ? "-" : number_format($final3, 2, ',', '.') ?></td>

                            </tr>

                            <tr>
                                <td class="text-center">
                                    <br><br>
                                    <p> <?php
                                        $ass1 = new Assinatura();
                                        $ass1->setMatricula($mat_orientador);
                                        $dadosOr = $ass1->pesquisarPorID();
                                        foreach ($dadosOr as $mostrar1) {
                                            $imagem1 = $mostrar1['imagem'] == NULL ? "" : $mostrar1['imagem'];
                                        }
                                        ?>
                                        <?= ($imagem1 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem1 . '" style="width: 150px;">') ?>
                                        <br>
                                        Prof. Orientador: <?= mb_strtoupper($orientador, 'UTF-8') ?></p>
                                    <?= $imagem1 = "" ?>
                                </td>
                                <td colspan="2" class="text-center">
                                    <br><br>
                                    <p>
                                        <?php
                                        $ass2 = new Assinatura();
                                        $ass2->setMatricula($mat_area);
                                        $dadosAr = $ass2->pesquisarPorID();
                                        foreach ($dadosAr as $mostrar2) {
                                            $imagem2 = $mostrar2['imagem'] == NULL ? "" : $mostrar2['imagem'];
                                        }
                                        ?>
                                        <?= ($imagem2 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem2 . '" style="width: 150px;">') ?>
                                        <br>


                                        Área: <?= mb_strtoupper($area, 'UTF-8') ?></p>
                                    <?= $imagem2 = "" ?>
                                </td>
                                <td colspan="2" class="text-center">
                                    <br><br>
                                    <p>
                                        <?php
                                        $ass3 = new Assinatura();
                                        $ass3->setMatricula($mat_convidado);
                                        $dadosCo = $ass3->pesquisarPorID();
                                        foreach ($dadosCo as $mostrar3) {
                                            $imagem3 = $mostrar3['imagem'] == NULL ? "" : $mostrar3['imagem'];
                                        }
                                        ?>
                                        <?= ($imagem3 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem3 . '" style="width: 150px;">') ?>
                                        <br>

                                        Convidado: <?= mb_strtoupper($convidado, 'UTF-8') ?></p>
                                    <?= $imagem3 = "" ?>

                                </td>
                                <td class="text-center">
                                    <br><br>
                                    <p>________________________<br>

                                        Aluno: <?= mb_strtoupper($a, 'UTF-8') ?></p>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div style="page-break-before: always;"> </div>
        <?php
    }
}
?>



