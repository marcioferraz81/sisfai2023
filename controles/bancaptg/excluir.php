<?php
include_once 'cabecalho.php';
?>
<?php
//capturar id da url
$banca = filter_input(INPUT_GET, 'banca');

//estabelecer conversa com a class Categoria
include_once '../class/BancaPTG.php';
$b = new BancaPTG();

$b->setCodBanca($banca);

if ($b->excluir()) {
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
<meta http-equiv="refresh" CONTENT="1;URL=?p=bancaptg/montar">