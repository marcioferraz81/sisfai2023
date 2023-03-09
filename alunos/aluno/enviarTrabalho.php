<?php

include_once 'cabecalho.php';
?>

<?php
$ra = $_SESSION['ra'];
$tipo == "ptg" ? include_once 'aluno/enviarPTG.php' : include_once 'aluno/enviarTG.php';
