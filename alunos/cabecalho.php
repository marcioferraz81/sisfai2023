<?php
date_default_timezone_set('America/Sao_Paulo');
(!isset($_SESSION)) ? session_start() : "";
$nivel = 0; //0,1 ou 2

if ($_SESSION['acesso_aluno'] != '9c13e3196f335ab2378e786ce650c0c38d70fd21' OR $_SESSION['nivel_aluno'] < $nivel) {
    header("location:logout.php");
}
if (isset($_SESSION['start_login']) && (time() - $_SESSION['start_login'] > 600)) {
    header("location:logout.php");
}
$_SESSION['start_login'] = time();

$ra = $_SESSION['ra'];
$tipo = $_SESSION['tipo_trabalho'];

