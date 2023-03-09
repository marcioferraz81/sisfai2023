<?php

include_once 'cabecalho.php';
?>

<?php

include_once '../class/Aluno.php';
$a = new Aluno();
$a->setRa($ra);
$dados = $a->pesquisarAvaliacaoBancaPTG();
$tipo = 'ptg';

$media = 0;
$cont = 0;

if (count($dados) == 0) {
    $dados = $a->pesquisarAvaliacaoBancaTG();
    $tipo = 'tg';
}
foreach ($dados as $mostrar) {
    $nota = $mostrar['nota_orientador'] == null ? "-" : $mostrar['nota_orientador'];
    $v = $mostrar['vinculo'] == null ? "-" : $mostrar['vinculo'];
}

if ($tipo == 'ptg') {
    include_once 'notasBancaPTG.php';
} else {
    include_once 'notasBancaTG.php';
}
