
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
//capturar id da url

//estabelecer conversa com a class Categoria
include_once '../class/Assinatura.php';
$doc = new Assinatura();

$doc->setMatricula($_SESSION['matricula']);

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
<meta http-equiv="refresh" CONTENT="1;URL=?p=docente/consultarAssinatura">