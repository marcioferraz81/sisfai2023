<?php
include_once 'cabecalho.php';
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Listar Docentes
        <a class="btn btn-primary float-right" href="?p=docente/salvar">Cadastrar</a>
        <a class="btn btn-link float-right mr-2" href="?p=docente/salvarXLS">Inserir via XLSX</a>
    </h1>
</div>
<div class="table-responsive-sm mt-4">
    <div class="card shadow">
        <!-- striped é para zebrar as linhas, cada uma com uma cor-->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Matr.</th>
                    <th>Nome</th>
                    
                    <th>Tipo</th>
                    <th>HAE</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>  
                <!--foreach aqui BEGIN-->
                <?php
                //estabelecer conversa com a class Categoria
                include_once '../class/Docente.php';
                $doc = new Docente();

                $dados = $doc->consultar();

                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td><?= $mostrar[0] ?></td>
                        <td><?= $mostrar[1] ?></td>
                        
                        <td><?= $mostrar[3] == 1 ? "Docente" : "Admin" ?></td>
                        <td><?= $mostrar[4] ?></td>
                        <td>
                            <!--MODAL já está pronto no JS, exemplos de modal em Bootstrap-->
                            <a href="?p=docente/excluir&matricula=<?= $mostrar[0] ?>" class="btn btn-danger ml-2 mb-1" data-confirm="Excluir registro?" title="excluir">
                                <i class="bi bi-trash-fill"></i>
                            </a>                        

                            <a href="?p=docente/salvar&matricula=<?= $mostrar[0] ?>" class="btn btn-primary ml-2 mb-1" title="editar registro">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <a href="?p=docente/alterarSenha&matricula=<?= $mostrar[0] ?>" class="btn btn-secondary ml-2" title="trocar senha">
                                <i class="bi bi-arrow-repeat"></i>
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


