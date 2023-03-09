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
$tipo = filter_input(INPUT_GET, 'tipo');
$aluno = filter_input(INPUT_GET, 'aluno');
$nome = filter_input(INPUT_GET, 'nome');

include_once '../class/Aluno.php';
$a = new Aluno();
$a->setRa($aluno);
$dados = 0;
$max = 0;

switch ($tipo) {
    case 'ptg':
        $dados = $a->pesquisarPTG();
        $max = 3;
        include_once '../class/VinculoPTG.php';
        $trab = new VinculoPTG();
        break;
    case 'tg':
        $dados = $a->pesquisarTG();
        $max = 10;
        include_once '../class/VinculoTG.php';
        $trab = new VinculoTG();
        break;
}
if ($dados != 0) {
    foreach ($dados as $mostrar) {
        $titulo = $mostrar[0];
        $link_video = $mostrar[1];
        $link_drive = $mostrar[2];
        $primeira_nota = $mostrar[3];
    }
}
?>

<h4>Etapa 2: <?= strtoupper($tipo) ?> - atribua nota de 0 a <?= $max ?>. (<?= $nome ?>).</h4>

<div class="row mb-4">
    <div class="col-md-12 col-sm-12">        
        <div class="card shadow">
            <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
                <!-- m-3 determinei todas as bordas, não mudei o form-->

                <div class="form-group row">            
                    <label for="inputText" class="col-sm-1 col-form-label">                
                        Nota
                    </label>
                    <div class="col-sm-3">                       
                        <input id="input" type="number" class="form-control" name="txtnota" required step="0.10" min="0" max="<?= $max ?>" value="<?= $primeira_nota ?>" />
                    </div>               
                    <div class="col-sm-5">            
                        <input type="submit" class="btn btn-primary" name="btn_encaminhar" value="Atribuir nota">   
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>

<?php
if (filter_input(INPUT_POST, 'btn_encaminhar')) {
    $nota = filter_input(INPUT_POST, 'txtnota');
    $trab->setAluno($aluno);
    $trab->setPrimeira_nota($nota);

    if ($trab->editarNota()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Nota atribuída com sucesso.
        </div>
        <meta http-equiv="refresh" CONTENT="0.1;URL=?p=pagina-inicial">
        <?php
    }
}
