<?php
include_once 'cabecalho.php';
?>
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Listar Docentes com TG
    </h1>
</div>
<div class="table-responsive-sm mt-4">
    <div class="card shadow mb-4">
        <!-- striped é para zebrar as linhas, cada uma com uma cor-->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Nr de TGs</th>
                    <th>Nr de HAEs</th>
                </tr>
            </thead>
            <tbody>  
                <!--foreach aqui BEGIN-->
                <?php
                //estabelecer conversa com a class Categoria
                include_once '../class/Docente.php';
                $doc = new Docente();

                $dados = $doc->haesTGPorDocente();

                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td><?= $mostrar[0] ?></td>
                        <td><?= $mostrar[1] ?></td>
                        <td><?= $mostrar[2] ?></td>
                        <td><?= $mostrar[3] ?></td>
                    </tr>
                    <?php
                }
                ?>
                <!--foreach aqui END-->
            </tbody>
        </table>
    </div>
</div>


