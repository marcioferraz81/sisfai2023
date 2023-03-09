<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$matricula = filter_input(INPUT_GET, 'matricula');

//estabelecer conversa com a class Categoria
include_once '../class/Docente.php';
$doc = new Docente();

$doc->setMatricula($matricula);

if ($doc->excluir()) {
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
<meta http-equiv="refresh" CONTENT="1;URL=?p=docente/consultar">