<?php
include_once 'cabecalho.php';
include_once '../class/Assinatura.php';
$doc = new Assinatura();
$dados = $doc->consultar();
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Listar Assinaturas - docente
        <a class="btn btn-primary float-right" href="?p=docente/salvarAssinatura">nova assinatura</a>
    </h1>
</div>

<div class="col-sm-12 mb-4">
    <div class="table-responsive-sm">
        <div class="card shadow">
            <!-- striped é para zebrar as linhas, cada uma com uma cor-->
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Docente</th>
                        <th>Assinatura</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    if ($dados != FALSE) {
                        foreach ($dados as $mostrar) {
                            ?>
                            <tr>
                                <td><?= $mostrar[4] ?></td>
                                <td><img src="../assinatura/<?= $mostrar[2] ?>" alt="assinatura" style="width: 100px;"></td>
                                <td>
                                    <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                                    <a href="?p=docente/excluirAssinatura&matricula=<?= $mostrar[1] ?>" class="btn btn-danger ml-2 mb-1" data-confirm="Excluir registro?" title="excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>                        
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <!--foreach aqui END-->
                </tbody>
            </table>


        </div>

    </div>
</div>
