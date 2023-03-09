
<?php
include_once 'cabecalho.php';
?>

<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    Alterar senha de Docente
</h1>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">
                Informe a nova senha
            </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="txtsenha" name="txtsenha" maxlength="8" minlength="6">
            </div>
        </div>
        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">
                Confirme a senha
            </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="txtsenha2" name="txtsenha2"  maxlength="8" minlength="6">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn btn-primary" 
                       name="btnsalvar" 
                       value="Cadastrar">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=docente/consultar" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
    $senha2 = filter_input(INPUT_POST, 'txtsenha2', FILTER_SANITIZE_STRING);

    if ($senha == $senha2) {
        include_once '../class/Docente.php';
        $doc = new Docente();
        $matricula = filter_input(INPUT_GET, 'matricula');

        $doc->setMatricula($matricula);
        $doc->setSenha($senha);

        if ($doc->alterarSenha()) {
            ?>
            <div class="alert alert-primary mt-3" role="alert">
                Cadastrado com sucesso
            </div>
            <meta http-equiv="refresh" CONTENT="2;URL=?p=docente/consultar">
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger mt-3" role="alert">
            Senhas diferentes
        </div>
        <?php
    }
}


