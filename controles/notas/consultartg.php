<?php
include_once 'cabecalho.php';
?>
<div class="col-sm-12">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Dupla</th>
                        <th>Orientador</th>
                        <th>Média Final</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    //estabelecer conversa com a class Categoria
                    include_once '../class/VinculoTG.php';
                    include_once '../class/BancaTG.php';
                    $c = new VinculoTG();

                    echo "<h3 class='m-3'>" . $_SESSION['nome_curso'] . " (Trabalhos de TG)";
                    echo "</h3>";

                    $dados = $c->consultar($_SESSION['curso']);
                    foreach ($dados as $mostrar) {
                        $b = new BancaTG();
                        $b->setVinculoTG($mostrar['vinculo']);
                        $dados2 = $b->pesquisarNotasBancaPorVinculo();
                        $media = 0;
                        $cont = 0;
                        $escrita = 0;
                        $oral = 0;
                        $formatacao = 0;
                        foreach ($dados2 as $mostrar2) {
                            $cont++;
                            $media = $media + ($mostrar2[1] == null ? 0 : $mostrar2[1]);
                            $escrita = $escrita + ($mostrar2[4] == null ? 0 : $mostrar2[4]);
                            $oral = $oral + ($mostrar2[5] == null ? 0 : $mostrar2[5]);
                            $formatacao = $formatacao + ($mostrar2[0] == 'orientador' ? $mostrar2[6] : 0);
                        }
                        $oral = ($oral == 0 ? 0 : ($oral / $cont) * 0.3);
                        $escrita = ($escrita == 0 ? 0 : ($escrita / $cont) * 0.4);
                        $formatacao = ($formatacao == 0 ? 0 : $formatacao * 0.1);

                        $final = $oral + $escrita + $formatacao + ($mostrar['nota'] * 0.2);
                        ?>
                        <tr>
                            <!--<td> //substr(sha1($mostrar[0] . $mostrar[1]), 0, 4) </td>-->
                            <td><?= $mostrar[5] ?></td>
                            <td><?= $mostrar[6] ?></td>
                            <td>Prof. <?= $mostrar[4] ?></td>
                            <td><?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?></td>
                            <td>
                                <a href="?p=notas/notasBancaTG&vinculo=<?= $mostrar['vinculo'] ?>&aluno=<?= $mostrar[5] ?>&nota=<?= $mostrar['nota'] ?>" class="btn btn-success" title="confirmar">
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