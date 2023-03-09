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

$ra = filter_input(INPUT_GET, 'ra');
$vinculo = filter_input(INPUT_GET, 'vinculo');
$aluno = filter_input(INPUT_GET, 'aluno');
$id = filter_input(INPUT_GET, 'id');
$nota = filter_input(INPUT_GET, 'nota');

include_once '../class/Aluno.php';
$a = new Aluno();
$a->setRa($ra);

$consultar = $a->pesquisarTG();

if ($consultar != 0) {
    foreach ($consultar as $mostrar) {
        $titulo = $mostrar[0];
        $link_video = $mostrar[1];
        $link_drive = $mostrar[2];
    }
} else {
    $link_video = "<h3>trabalho não enviado</h3>";
}
?>

<div class="row">

    <div class="col-sm-12 col-md-12 mb-4">
        <?php
        //if ($link_drive == null OR $link_video == null OR $titulo == null) {
            //echo "<h4>O aluno deve enviar o trabalho com título, vídeo e link do drive.</h4>";
        //} else {
            ?>
            <a href="?p=notas/avaliaTG&id=<?= $id ?>&nota=<?= $nota ?>" class="btn btn-primary" title="confirmar">
                <i class="bi bi-check2-circle"></i> Avaliar
            </a>
        <?php //} ?>
        <a href="?p=notas/listar" class="btn btn-danger mr-1" title="confirmar">
            <i class="bi bi-arrow-return-left"></i> Voltar
        </a>
    </div>

    
    <div class="col-md-6 col-sm-12">
        <div class="card shadow" style="background: #99ccff;">
            <?php
            if ($link_video == null) {
                echo "<h4>Vídeo não enviado</h4>";
            } else {
                ?>
                <iframe width="100%" height="250px" src="https://www.youtube.com/embed/<?= $link_video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php } ?>
        </div>
    </div> 
    <div class="col-md-6 col-sm-12">        
        <h3 class="mb-4">Aluno: <?= mb_strtoupper($aluno, 'UTF-8') ?></h3>
        <h4 class="mb-4">Título: <?= $titulo == null ? "não informado" : mb_strtoupper($titulo, 'UTF-8') ?></h4>
        <?php
        if ($link_drive == null) {
            echo "<h4>Link de drive não informado</h4>";
        } else {
            ?>
            <a href="<?= $link_drive ?>" target="_blank" class="btn btn-primary" title="confirmar">
                <i class="bi bi-search"></i> Ver material no drive
            </a>
        <?php } ?>

    </div> 

</div>

