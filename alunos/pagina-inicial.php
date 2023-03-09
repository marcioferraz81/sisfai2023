<?php
include_once 'cabecalho.php';

include_once '../class/Aluno.php';
$a = new Aluno();
$a->setRa($ra);
if (count($a->pesquisarSemVinculoPorRA()) == 0) {
    $mostrarBtn = '<a href="?p=aluno/enviarTrabalho" class="btn btn-danger btn-lg float-right mr-2">Postar trabalho</a>';
} else {
    $mostrarBtn = '<span class="btn btn-warning">Você ainda não tem vínculo.</span>';
}

$consultar = $a->pesquisarPTG();

if ($consultar == 0) {
    $consultar = $a->pesquisarTG();
}


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
<!--
<div class="row mb-2">
    <div class="col-md-12 col-sm-12">
        <?php //include_once 'aluno/enviarTitulo.php'; ?>
    </div>
</div>
-->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="jumbotron">
            <h4 class="display-6">Seja bem vindo RA: <strong><?= $ra ?></strong></h4>
            <p class="lead">Este é seu espaço para postar seu trabalho, atualizar cadastro e acompanhar notas atribuídas pela banca.</p>
            <hr class="my-4">
            <a class="btn btn-primary btn-lg float-right mr-2" href="?p=aluno/editar" role="button">Atualizar cadastro</a>
           <?= $mostrarBtn ?>
        </div>
    </div>
</div>




