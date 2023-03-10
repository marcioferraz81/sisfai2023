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
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    //estabelecer conversa com a class Categoria
                    include_once '../class/VinculoPTG.php';
                    $c = new VinculoPTG();
                    echo "<h3 class='m-3'>" . $_SESSION['nome_curso'] . " (Vínculos PTG)";
                    echo '<a class = "btn btn-link float-right" href = "?p=../class/ExportarXLSX">Exportar Vínculos</a>';
                    echo '<a class = "btn btn-success float-right mr-2" href = "?p=vinculo/salvarptg"><i class="bi bi-pencil-square"></i> Incluir vínculo</a>' . "</h3>";
                    //$dados = $c->consultar();
                    $dados = $c->consultarCoordenador($_SESSION['curso']);
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?= $mostrar[5] ?></td>
                            <td><?= $mostrar[6] ?></td>
                            <td>Prof. <?= $mostrar[4] ?></td>
                            <td>
                                <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->

                                <div class="row">
                                    <div class="col-6">
                                        <a href="?p=vinculo/editarptg&professor=<?= $mostrar[0] ?>&ra=<?= $mostrar[1] ?>&semestre=<?= $mostrar[2] ?>" class="btn btn-link" title="editar registro">
                                            <i class="bi bi-pencil-fill"></i> registro
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="?p=vinculo/excluir&professor=<?= $mostrar[0] ?>&ra=<?= $mostrar[1] ?>&semestre=<?= $mostrar[2] ?>" class="btn btn-link" data-confirm="Excluir registro?" title="excluir">
                                            <i class="bi bi-trash-fill"></i> registro
                                        </a> 
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">                                
                                        <a href="?p=vinculo/adicionardupla&professor=<?= $mostrar[0] ?>&ra=<?= $mostrar[1] ?>&semestre=<?= $mostrar[2] ?>" class="btn btn-link" title="editar registro">
                                            <i class="bi bi-pencil-fill"></i> dupla
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="?p=vinculo/excluirdupla&professor=<?= $mostrar[0] ?>&ra=<?= $mostrar[1] ?>&semestre=<?= $mostrar[2] ?>" class="btn btn-link" data-confirm="Excluir registro?" title="excluir"> <i class="bi bi-trash-fill"></i> dupla
                                        </a>
                                    </div>
                                </div>


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

