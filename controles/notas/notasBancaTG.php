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
$nota = filter_input(INPUT_GET, 'nota') == null ? 0 : filter_input(INPUT_GET, 'nota');
include_once '../class/BancaTG.php';
$b = new BancaTG();
$b->setVinculoTG($v);
$dados = $b->pesquisarNotasBancaPorVinculo();

include_once '../class/Assinatura.php';
$ass = new Assinatura();
?>

<div class="row text-right">
    <div class="col-sm-12 col-md-12">        
        <a onclick="window.print()" href="#" class="mr-3" ><i class="bi bi-printer"></i> Imprimir </a>
        <a href="?p=notas/consultartg" title="confirmar">
            <i class="bi bi-arrow-return-left"></i> Voltar
        </a>
    </div>
    <div class="col-sm-12 col-md-12 text-justify">
        <h3 class="text-center">ATA</h3>
        <p>Indaiatuba, <?= date('d/m/Y') ?></p>
        <p class="text-justify">Aos <?= utf8_encode(strftime('%d de %B de %Y', strtotime(date('Y-m-d')))) ?>, na sala de Coordenação da Faculdade de Tecnologia de Indaiatuba – Rua Dom Pedro I, 65 - Cidade Nova I, Indaiatuba/SP, foi realizada uma reunião entre coordenador de curso e o aluno <?= mb_strtoupper($a, 'UTF-8') ?>, com objetivo de documentar as notas atribuídas ao trabalho de TG.</p>

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
                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td class="text-left"><?= $mostrar[3] ?></td>
                        <td><?= $mostrar[0] ?></td>

                        <td><?= number_format($mostrar[4], 2, ',', '.') ?></td>
                        <td><?= number_format($mostrar[5], 2, ',', '.') ?></td>
                        <td><?= $mostrar[0] == 'orientador' ? number_format($mostrar[6], 2, ',', '.') : "-" ?></td>

                        <?php
                        $cont++;
                        ?>
                        <td class="text-justify"><?= $mostrar[2] ?></td>
                    </tr>
                    <?php
                    $media = $media + ($mostrar[1] == null ? 0 : $mostrar[1]);
                    $escrita = $escrita + ($mostrar[4] == null ? 0 : $mostrar[4]);
                    $oral = $oral + ($mostrar[5] == null ? 0 : $mostrar[5]);
                    $formatacao = $formatacao + ($mostrar[0] == 'orientador' ? $mostrar[6] : 0);

                    switch ($mostrar[0]) {
                        case 'orientador':
                            $orientador = $mostrar[3];
                            $mat_orientador = $mostrar['mat'];
                            break;
                        case 'área':
                            $area = $mostrar[3];
                            $mat_area = $mostrar['mat'];
                            break;
                        case 'convidado':
                            $convidado = $mostrar[3];
                            $mat_convidado = $mostrar['mat'];
                            break;
                    }
                }
                //$media = $media / $cont;
                $oral = ($oral == 0 ? 0 : ($oral / $cont) * 0.3);
                $escrita = ($escrita == 0 ? 0 : ($escrita / $cont) * 0.4);
                $formatacao = ($formatacao == 0 ? 0 : $formatacao * 0.1);

                $final = $oral + $escrita + $formatacao + ($nota * 0.2);
                ?>                
                <!--foreach aqui END-->
                </tbody>
                <tfoot>
                    <tr  style="background: #66ccff; font-weight: bolder;" class="p-3 text-center">
                        <td>Nota Final</td>
                        <td>-</td>
                        <td><?= ($escrita == null OR empty($escrita)) ? "-" : number_format($escrita, 2, ',', '.') ?></td>
                        <td><?= ($oral == null OR empty($oral)) ? "-" : number_format($oral, 2, ',', '.') ?></td>
                        <td><?= ($formatacao == null OR empty($formatacao)) ? "-" : number_format($formatacao, 2, ',', '.') ?></td>
                        <td><?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?></td>

                    </tr>
                    <tr>
                        <td class="text-center">
                            <br><br>
                            <p>
                                <?php
                                $ass->setMatricula($mat_orientador);
                                $dadosOr = $ass->pesquisarPorID();
                                foreach ($dadosOr as $mostrar1) {
                                    $imagem1 = $mostrar1['imagem'];
                                }
                                ?>
                                <?= ($imagem1 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem1 . '" style="width: 150px;">') ?>
                                <br>

                                Prof. Orientador: <?= mb_strtoupper($orientador, 'UTF-8') ?></p>

                        </td>
                        <td colspan="2" class="text-center">
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

                        </td>
                        <td colspan="2" class="text-center">
                            <br><br>
                            <p>
                                <?php
                                $ass->setMatricula($mat_convidado);
                                $dadosCo = $ass->pesquisarPorID();
                                foreach ($dadosCo as $mostrar3) {
                                    $imagem3 = $mostrar3['imagem'];
                                }
                                ?>
                                <?= ($imagem3 == NULL ? "" : '<img src="https://fatecid.com.br/sisfai2022/assinatura/' . $imagem3 . '" style="width: 150px;">') ?>
                                <br>


                                Convidado: <?= mb_strtoupper($convidado, 'UTF-8') ?></p>

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

