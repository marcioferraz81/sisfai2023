
<?php
include_once 'cabecalho.php';
?>

<?php
//estabelecer conversa com a class Categoria
include_once '../class/Docente.php';
$doc = new Docente();
$consulta = $doc->consultar();
?>


<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    Cadastrar Assinatura de Docente
</h1>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Docente
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="seldocente" id="seldocente" required>
                    <option selected disabled>Escolha o docente</option>
                    <?php
                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>"><?= $mostrar[1] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>

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
    $matricula = filter_input(INPUT_POST, 'seldocente', FILTER_SANITIZE_NUMBER_INT);

    include_once '../class/Assinatura.php';
    $ass = new Assinatura();

    if (strstr('png', $extensao) || strstr('jpg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $ass->setArquivo($novoNome);
        $ass->setTemp_arquivo($imagem['tmp_name']);
        $ass->setMatricula($matricula);
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
    