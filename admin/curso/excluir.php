
<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$id = filter_input(INPUT_GET, 'id');

//estabelecer conversa com a class Categoria
include_once '../class/Curso.php';
$c = new Curso();

$c->setId($id);

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
<meta http-equiv="refresh" CONTENT="1;URL=?p=curso/consultar">