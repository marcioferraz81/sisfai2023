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

include_once '../class/VinculoPTG.php';
include_once '../class/BancaPTG.php';
$c = new VinculoPTG();
$dados = $c->consultar2($_SESSION['curso'], $semestre);

foreach ($dados as $mostrar) {
    $b = new BancaPTG();
    $b->setVinculoPTG($mostrar['vinculo']);
    $dados2 = $b->pesquisarNotasBancaPorVinculo();
    $dados3 = $b->pesquisarNotasBancaPorVinculo();
    $media = 0;
    $cont = 0;

    include_once '../class/Assinatura.php';
    $ass = new Assinatura();
    foreach ($dados2 as $mostrar2) {
        $cont++;
        $media = $media + ($mostrar2[4] == null ? 0 : $mostrar2[4]);
    }
    $cont = ($cont == 0 ? 1 : $cont);
    $final = (($media / $cont)) + $mostrar['nota'];
    if ($mostrar['nota'] != 0 || !empty($mostrar['nota']) || $mostrar['nota'] != null) {
        ?>

        <div class="row text-right">
            <div class="col-sm-12 col-md-12 text-justify">
                <h3 class="text-center">ATA<br><?= substr($semestre, -1) ?>º Semestre - <?= substr($semestre, 0, 4) ?></h3>
                <p>Indaiatuba, <?= date('d/m/Y') ?></p>
                <p class="text-justify">Aos <?= utf8_encode(strftime('%d de %B de %Y', strtotime(date('Y-m-d')))) ?>, na sala de Coordenação da Faculdade de Tecnologia de Indaiatuba – Rua Dom Pedro I, 65 - Cidade Nova I, Indaiatuba/SP, foi realizada uma reunião entre coordenador de curso e o aluno <?= mb_strtoupper($mostrar[5], 'UTF-8') ?><?= ($mostrar[6] != null || !empty($mostrar[6])) ? " e a dupla" . mb_strtoupper($mostrar[6], 'UTF-8') : "" ?>, com objetivo de documentar as notas atribuídas ao trabalho de PTG.</p>

                <h5 style="color: red;">Nota do orientador: <?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?>.</h5>

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
                        foreach ($dados3 as $mostrar3) {
                            ?>
                            <tr>
                                <td class="text-left"><?= $mostrar3[9] ?></td>
                                <td><?= $mostrar3[3] ?></td>
                                <td><?= ($mostrar3[4] == null OR empty($mostrar3[4])) ? "-" : number_format($mostrar3[4], 2, ',', '.') ?></td>
                                <td class="text-justify"><?= $mostrar3[8] ?></td>
                            </tr>
                            <?php
                            $cont3++;
                            $media3 = $media3 + ($mostrar3[4] == null ? 0 : $mostrar3[4]);
                            switch ($mostrar3[3]) {
                                case 'orientador':
                                    $orientador = $mostrar3[9];
                                    $mat_orientador = $mostrar3['mat'];
                                    break;
                                case 'área':
                                    $area = $mostrar3[9];
                                    $mat_area = $mostrar3['mat'];
                                    break;
                                case 'convidado':
                                    $convidado = $mostrar3[9];
                                    $mat_convidado = $mostrar3['mat'];
                                    break;
                            }
                        }
                        $cont3 = ($cont3 == 0 ? 1 : $cont3);
                        $final3 = (($media3 / $cont3)) + $mostrar['nota'];
                        ?>
                        <!--foreach aqui END-->
                        </tbody>
                        <tfoot >
                            <tr style="background: #66ccff; font-weight: bolder;" class="p-3 text-center">
                                <td colspan="4" class="text-right">
                                    Nota Final: <?= ($final3 == null OR empty($final3)) ? "-" : number_format($final3, 2, ',', '.') ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center">
                                    <br><br>
                                    <p> <?php
                                        $ass->setMatricula($mat_orientador);
                                        $dadosOr = $ass->pesquisarPorID();
                                        foreach ($dadosOr as $mostrar1) {
                                            $imagem1 = $mostrar1['imagem'];
                                        }
                                        ?>
                                        <?= ($imagem1 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem1 . '" style="width: 150px;">') ?>
                                        <br>
                                        Prof. Orientador: <?= mb_strtoupper($orientador, 'UTF-8') ?></p>
                                    <?= $imagem1 = "" ?>
                                </td>
                                <td class="text-center">
                                    <br><br>
                                    <p>
                                        <?php
                                        $ass->setMatricula($mat_area);
                                        $dadosAr = $ass->pesquisarPorID();
                                        foreach ($dadosAr as $mostrar2) {
                                            $imagem2 = $mostrar2['imagem'];
                                        }
                                        ?>
                                        <?= ($imagem2 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem2 . '" style="width: 150px;">') ?>
                                        <br>

                                        Área: <?= mb_strtoupper($area, 'UTF-8') ?></p>
                                    <?= $imagem2 = "" ?>
                                </td>

                                <td colspan="2" class="text-center">
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



