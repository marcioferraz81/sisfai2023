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

$vinculoTG = filter_input(INPUT_GET, 'id');
$professor = filter_input(INPUT_GET, 'professor');
//$tipoBanca = filter_input(INPUT_GET, 'tipo');

include_once '../class/BancaTG.php';
$b = new BancaTG();
$b->setVinculoTG($vinculoTG);
$b->setProfessor($professor);
$b->setTipoBanca("orientador");

$b->salvarPrimeiraEtapa();
?>

<div class="alert alert-info" role="alert">
  Trabalho enviado ao coordenador para montagem de banca.
</div>

<meta http-equiv="refresh" CONTENT="0.1;URL=?p=pagina-inicial">