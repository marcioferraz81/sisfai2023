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
                    include_once '../class/VinculoPTG.php';
                    include_once '../class/BancaPTG.php';
                    $c = new VinculoPTG();
                    echo "<h3 class='m-3'>" . $_SESSION['nome_curso'] . " (Trabalho de PTG)";
                    echo "</h3>";
                    //$dados = $c->consultar();
                    $dados = $c->consultar($_SESSION['curso']);
                    foreach ($dados as $mostrar) {
                        $b = new BancaPTG();
                        $b->setVinculoPTG($mostrar['vinculo']);
                        $dados2 = $b->pesquisarNotasBancaPorVinculo();
                        $media = 0;
                        $cont = 0;
                        foreach ($dados2 as $mostrar2) {
                            $cont++;
                            $media = $media + ($mostrar2[4] == null ? 0 : $mostrar2[4]);
                        }
                        $cont = ($cont == 0 ? 1 : $cont);
                        $final = (($media / $cont)) + $mostrar['nota'];
                        ?>
                        <tr>
                            <td><?= $mostrar[5] ?></td>
                            <td><?= $mostrar[6] ?></td>
                            <td>Prof. <?= $mostrar[4] ?></td>
                            <td><?= ($final == null OR empty($final)) ? "-" : number_format($final, 2, ',', '.') ?></td>
                            <td>
                                <a href="?p=notas/notasBancaPTG&vinculo=<?= $mostrar['vinculo'] ?>&aluno=<?= $mostrar[5] ?>&nota=<?= $mostrar['nota'] ?>" class="btn btn-success" title="confirmar">
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

