<?php
include_once 'cabecalho.php';
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Listar Cursos
        <a class="btn btn-primary float-right" href="?p=curso/salvar">Cadastrar</a>
    </h1>
</div>
<div class="table-responsive-sm mt-4">
    <div class="card shadow mb-4">
        <!-- striped é para zebrar as linhas, cada uma com uma cor-->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Período</th>
                    <th>Coordenador</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>  
                <!--foreach aqui BEGIN-->
                <?php
                //estabelecer conversa com a class Categoria
                include_once '../class/Curso.php';
                $c = new Curso();

                $dados = $c->consultar();

                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td><?= $mostrar[2] ?></td>
                        <td><?= $mostrar[1] ?></td>
                        <td><?= $mostrar[5] ?></td>
                        <td>
                            <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                            <a href="?p=curso/excluir&id=<?= $mostrar[0] ?>" class="btn btn-danger ml-2 " data-confirm="Excluir registro?" title="excluir">
                                <i class="bi bi-trash-fill"></i>
                            </a>                        

                            <a href="?p=curso/salvar&id=<?= $mostrar[0] ?>" class="btn btn-primary ml-2" title="editar registro">
                                <i class="bi bi-pencil-fill"></i>
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


