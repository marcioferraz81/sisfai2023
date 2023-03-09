<?php
include_once 'cabecalho.php';
?>

<?php
//estabelecer conversa com a class Categoria
include_once '../class/BancaTG.php';
$b = new BancaTG();

$matricula = $_SESSION['matricula'];

$b->setProfessor($matricula);
$dados = $b->pesquisarSegundaEtapa();

/*
  $codbanca = $mostrar[0];
  $vinculoptg = $mostrar[1];
  $professor = $mostrar[2];
  $tipobanca = $mostrar[3];
  $notabanca_final = $mostrar[4];
  $notabanca = $mostrar[5];
  $data = $mostrar[6];
  $status = $mostrar[7];
  $comentario = $mostrar[8];
  $nome_aluno = $mostrar[9];
  $nome_docente = $mostrar[10];
 * 
 */
?>

<div class="col-sm-12">
    <h4>Bem vindo(a) Prof(a). Coordenador(a), acompanhe abaixo os TGs para montagem de banca.<br><br>Etapa 2: montagem de banca.</h4>
</div>

<div class="col-sm-12 mt-4">
    <div class="table-responsive-sm mt-4">
        <div class="card shadow mb-4">
            <table class="table table-striped  table-sm">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th style="width: 350px;">Membros da banca</th>
                        <th>Título trabalho</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>  
                    <!--foreach aqui BEGIN-->
                    <?php
                    //estabelecer conversa com a class Categoria
                    echo "<h3 class='m-3'>TGs</h3>";
                    /* if (count($dados) == 0) {
                      ?>
                      <tr>
                      <td colspan="4"><h3 class="alert alert-warning mt-1 mb-1 p-2">Nenhuma banca para montar.</h3></td>
                      </tr>
                      <?php
                      } else { */
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?= mb_strtoupper($mostrar[35]) ?></td>

                            <td>
                                <?php
                                $dados3 = $b->buscarMembros(mb_strtoupper($mostrar[1]));
                                foreach ($dados3 as $mostrar2) {
                                    echo '<p>' . mb_strtoupper($mostrar2[2]);
                                    echo ($mostrar2[4] == null OR $mostrar2[4] == 0 OR empty($mostrar2[4])) ? ' <span style="color: red; font-weight: bold;">(não avaliou)</span> ' : '';
                                    ?>
                                    <a href="?p=bancatg/excluir&banca=<?= $mostrar2[0] ?>" class="btn btn-link ml-1" data-confirm="Excluir registro?" title="excluir">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php
                                    echo '</p>';
                                }
                                ?>
                            </td>

                            <td><?= $mostrar['titulo'] ?></td>
                            <td>
                                <?php
                                $dados2 = $b->contarMembrosBanca($mostrar[1]);
                                foreach ($dados2 as $mostrar2) {
                                    $i++;
                                }
                                if ($mostrar['status'] == 0) {
                                    ?>
                                    <a href="?p=bancatg/inserir&vinculo=<?= $mostrar[1] ?>&aluno=<?= strtoupper($mostrar[35]) ?>&titulo=<?= $mostrar['titulo'] ?>" class="btn btn-primary ml-2" title="confirmar">
                                        <i class="bi bi-check2-circle"></i> add membros
                                    </a> 
                                    <?php
                                } else {
                                    echo '<p>(em avaliação - ' . $i . ' membros na banca)</p>';
                                    //if ($i < 3) {
                                    ?>
                                    <a href="?p=bancatg/inserir&vinculo=<?= $mostrar[1] ?>&aluno=<?= strtoupper($mostrar[35]) ?>&titulo=<?= $mostrar['titulo'] ?>" class="btn btn-primary ml-2" title="confirmar">
                                        <i class="bi bi-check2-circle"></i> add membros
                                    </a> 
                                    <?php
                                    //}
                                }

                                $i = 0;
                                ?>

                            </td>
                        </tr>
                        <?php
                    }
                    //}
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>