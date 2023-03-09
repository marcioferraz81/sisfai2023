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
//$vinculo = filter_input(INPUT_GET, 'vinculo');
$id = filter_input(INPUT_GET, 'id');

if (isset($id)) {
    include_once '../class/BancaPTG.php';
    $b = new BancaPTG();
    $b->setCodBanca($id);
    $dados = $b->pesquisarTerceiraEtapaVinculo();
    foreach ($dados as $mostrar) {
        $tipo = $mostrar['tipoBanca'];
        $comentario = $mostrar['comentario'];
        $titulo = $mostrar['titulo'];
        $aluno = $mostrar['nome_aluno'];

        $notaBanca = $mostrar['notaBanca'];
        $notaBanca_Final = $mostrar['notaBanca_Final'];
    }
}
?>
<div class="col-sm-12 mb-4">
    <div class="card shadow mb-4">
        <h4 class="text-center font">Avaliação de Trabalho (<?= $tipo ?>)
        <a href="?p=notas/listar" class="btn btn-danger m-2">Cancelar</a>
        </h4>
        <hr class="text-muted mt-1">
        <h5 class="text-center font">Aluno(a): <?= $aluno ?></h5>
        <h5 class="text-center font">Tema:  <?= $titulo ?></h5>
        <hr class="text-muted mt-1">
        <form method="post" id="notas" action="">
            <div class="table-responsive-sm">
                <table class="table table-hover table-sm p-3">
                    <tbody>
                        <!--=============FORMULARIO DE ESCRITA============  -->
                        <tr class="mt-4">
                            <td>
                                <p class="text-center">Nota Final (de 0 a 7)</p>
                            </td>
                            <td class="text-center"><input type="number" max="7" min="0" step="0.1" id="notaBanca" name="notaBanca" class="form-control" value="<?= $notaBanca ?>"  required></td>
                        </tr>
                        <tr>
                            <th colspan="2" style="background: #ffff99;" class="text-center font">Comentário (Preenchimento Obrigatório)</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">                                
                                <textarea cols="100%" rows="10" minlength="10" name="comentario" required><?= $comentario ?></textarea>
                               
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 col-sm-12 d-flex">&nbsp;</div>
                    <!--============= BOTAO DE SALVAR ============= -->	
                    <div class="col-md-6 col-sm-12 d-flex">
                        <input class="btn btn-block btn-primary" value="Salvar" type="submit" name="btneditar"> 
                    </div>
                </div>
            </div>
        </form>
        <!--============= FIM FORMULARIO ============= -->	
    </div>
</div>

<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    $nota_banca = filter_input(INPUT_POST, 'notaBanca');
    $comentarios = filter_input(INPUT_POST, 'comentario');
    $b->setComentario($comentarios);
    $b->setNotaBanca($nota_banca);

    if ($b->editarNotasProfessor()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Notas enviadas com sucesso
        </div>
        <?php
        echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=notas/listar">';
        ?>

        <?php
    }
}    