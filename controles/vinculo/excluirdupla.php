<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');
$professor = filter_input(INPUT_GET, 'professor');
$semestre = filter_input(INPUT_GET, 'semestre');

//estabelecer conversa com a class Categoria
include_once '../class/VinculoPTG.php';
$vinculoptg = new VinculoPTG();

$vinculoptg->setAluno($ra);
$vinculoptg->setProfessor($professor);
$vinculoptg->setSemestre($semestre);

if ($vinculoptg->excluirdupla()) {
    ?>
    <div class="alert alert-primary" role="alert">
        Dupla excluída com sucesso
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
<meta http-equiv="refresh" CONTENT="1;URL=?p=vinculo/consultarptg">