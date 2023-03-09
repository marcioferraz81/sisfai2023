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
?>

<?php
$matricula = filter_input(INPUT_GET, 'professor');
$id = filter_input(INPUT_GET, 'id');

include_once '../class/Docente.php';
$d = new Docente();
$d->setMatricula($matricula);
$dadosD = $d->consultarPorID();
foreach ($dadosD as $mostrar) {
    $nome_professor = $mostrar[1];
}
?>

<div class="col-sm-12 mb-4">
    <h4>Caro professor orientador (TG), você está prestes a encaminhar o trabalho para que o Coordenador de curso indique os membros da banca.<br><br>Etapa 2: encaminhar para montagem da banca.</h4>
</div>

<a href="?p=bancatg/salvarPrimeiraEtapa&professor=<?= $matricula ?>&id=<?= $id ?>" class="btn btn-success ml-2">
    <i class="bi bi-check2-circle"> confirmar</i>
</a> 
<a href="?p=pagina-inicial" class="btn btn-danger ml-2">
    <i class="bi bi-x"></i> cancelar</i>
</a> 