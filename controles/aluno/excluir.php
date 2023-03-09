<?php
include_once 'cabecalho.php';
?>
<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');

//estabelecer conversa com a class Categoria
include_once '../class/Aluno.php';
$c = new Aluno();

$c->setRa($ra);

if ($c->excluir()) {
    ?>
    <div class="alert alert-primary" role="alert">
        Excluído com sucesso
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-danger" role="alert">
        Erro ao excluir
    </div>
    <?php
}
?>
<meta http-equiv="refresh" CONTENT="1;URL=?p=aluno/consultar">