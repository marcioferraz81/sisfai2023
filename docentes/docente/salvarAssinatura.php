
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
<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    Cadastrar Assinatura de Docente
</h1>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">
                Pesquisar imagem
            </label>
            <div class="col-sm-10">
                <input type="file" name="imagem" id="imagem">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" class="btn btn-primary" name="btnsalvar" value="Cadastrar">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=docente/consultarAssinatura" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>


<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {

    $imagem = $_FILES['imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    include_once '../class/Assinatura.php';
    $ass = new Assinatura();

    if (strstr('png', $extensao) || strstr('jpg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $ass->setArquivo($novoNome);
        $ass->setTemp_arquivo($imagem['tmp_name']);
        $ass->setMatricula($_SESSION['matricula']);
        $ass->enviarArquivos();

        if ($ass->salvar()) {
            ?>
            <div class="alert alert-primary mt-3" role="alert">
                Cadastrado com sucesso
            </div>
            <meta http-equiv="refresh" CONTENT="1;URL=?p=docente/consultarAssinatura">
            <?php
        }
        
    }
}
    