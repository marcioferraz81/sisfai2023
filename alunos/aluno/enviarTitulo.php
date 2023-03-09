<?php
include_once 'cabecalho.php';
?>

<?php
//$ra = $_SESSION['ra'];
include_once '../class/VinculoPTG.php';
$trab = new VinculoPTG();
$trab->setAluno($ra);
$dados = $trab->pesquisarPorRA();

if (count($dados) == 0) {
    include_once '../class/VinculoTG.php';
    $trab = new VinculoTG();
    $trab->setAluno($ra);
    $dados = $trab->pesquisarPorRA();
}

foreach ($dados as $mostrar) {
    $titulo = $mostrar['titulo'];
    $video = $mostrar['link_video'];
    $drive = $mostrar['link_drive'];
}
?>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        

        <div class="form-group row"> 
            <div class="col-sm-3">
                <h4>Título do trabalho</h4>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="txt_titulo" name="txt_titulo" placeholder="Título do trabalho" 
                       value="<?= isset($titulo) ? $titulo : "" ?>" maxlength="100">
            </div>
            <div class="col-sm-3">
                <input type="submit" 
                       class="btn <?= isset($ra) ? "btn-primary" : "btn-primary" ?>" 
                       name="<?= isset($ra) ? "btneditar" : "btnsalvar" ?>" 
                       value="<?= isset($ra) ? "Atualizar título" : "Informar título" ?>">               
            </div>
        </div>
        <!-- faltou um link aqui-->

    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {

    $titulo = filter_input(INPUT_POST, 'txt_titulo', FILTER_SANITIZE_STRING);

    $ano = date('Y');
    $semestre = date('m') < 7 ? 1 : 2;

    include_once '../class/Aluno.php';
    $al = new Aluno();
    $al->setRa($ra);

    $al->setSemestre($ano . $semestre);

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($al->enviarTrabalho($titulo, null, null)) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <?php
        //echo $al->getId_curso() . " - " . $al->getSemestre(). " - " . $al->getRa() . $al->getNome();
    }
}
?>

