<?php
include_once 'cabecalho.php';
?>

<h1 class="mt-3 text-primary">
    Listar Vinculos
    <a class="btn btn-link float-right mr-1" href="?p=../class/ExportarXLSX">Exportar Vínculos</a>
    <a class="btn btn-link float-right mr-2" href="?p=vinculo/salvarptg">Criar vínculo</a>

</h1>
<div class="card shadow mb-4">
    <!-- striped é para zebrar as linhas, cada uma com uma cor-->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Professor</th>
                <th>Semestre</th>
                <th>Aluno</th>
                <th>Dupla</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>  
            <!--foreach aqui BEGIN-->
            <?php
            //estabelecer conversa com a class Categoria
            include_once '../class/VinculoPTG.php';
            $c = new VinculoPTG();
            $dados = $c->consultar();
            foreach ($dados as $mostrar) {
                ?>
                <tr>
                    <td>Prof. <?= $mostrar[4] ?></td>
                    <td><?= $mostrar[2] ?></td>
                    <td><?= $mostrar[5] ?></td>
                    <td><?= $mostrar[6] ?></td>
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


