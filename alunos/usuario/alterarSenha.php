<?php
include_once 'cabecalho.php';

$tipoUser = $_SESSION['nivel'];

$matricula = explode('|', $_SESSION['nivel'])[1];
?>

<?php
include_once '../class/Usuario.php';
$u = new Usuario();
if (isset($matricula)) {
    $u->setMatricula($matricula);
}
?>
<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    Informe a nova senha
</h1>


<div class="card shadow mt-3 mb-4"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Informe a nova senha
            </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="txtsenha" name="txtsenha" placeholder="nova senha" maxlength="10" minlength="6">
            </div>
        </div>              
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Confirme a nova senha
            </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="txtconfirma" name="txtconfirma" placeholder="nova senha" maxlength="10" minlength="6">
            </div>
        </div>              

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn btn-success" 
                       name="btneditar" 
                       value="Editar">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=pagina-inicial" class="btn btn-danger">Página inicial</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
    $confirma = filter_input(INPUT_POST, 'txtconfirma', FILTER_SANITIZE_STRING);

    if ($senha == $confirma) {
        $u->setSenha($senha);
        ?>
        <div class="alert alert-primary mt-3" role="alert" >
            <?= $u->trocarSenha($tipoUser) ? "Senha alterada com sucesso" : "Senha alterada com sucesso" ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger mt-3" role="alert" >
            Senha e confirmação de senha não conferem!
        </div>
        <?php
    }
}

    