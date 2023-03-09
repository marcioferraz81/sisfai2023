<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$matricula = filter_input(INPUT_GET, 'matricula');

//estabelecer conversa com a class Categoria
include_once '../class/Docente.php';
$doc = new Docente();

if (isset($matricula)) {
    $doc->setMatricula($matricula);
    $dados = $doc->consultarPorID();
    foreach ($dados as $mostrar) {
        $nome = $mostrar[1];
        $status = $mostrar[2];
        $tipo = $mostrar[3];
        $hae = $mostrar[4];
    }
}
?>


<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($matricula) ? "Editar" : "Cadastrar" ?> Docente
</h1>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Matrícula
            </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="txtmatricula" name="txtmatricula"  
                       value="<?= isset($matricula) ? $matricula : "" ?>" <?= isset($matricula) ? "disabled" : "" ?>>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Nome
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtnome" name="txtnome" placeholder="Nome de Docente" 
                       value="<?= isset($matricula) ? $nome : "" ?>" maxlength="70">
            </div>
        </div>        

        <div class="form-group row">
            <label class="form-check-label col-sm-2" for="flexCheckChecked">
                Ativo
            </label>
            <div class="col-sm-1">
                <input class="form-control mr-auto" type="checkbox" value="1" name="chkstatus" id="flexCheckChecked" <?= (isset($matricula) AND $status == 1) ? "checked" : "" ?>> 
            </div>
        </div>


        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Tipo usuário
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="txttipo" id="txttipo" required>
                    <option value="1" <?= isset($matricula) && $tipo == 1 ? "selected" : "" ?>>Docente</option>
                    <option value="2" <?= isset($matricula) && $tipo == 2 ? "selected" : "" ?>>Administrador</option>
                </select>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">
                HAE
            </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="txthae" name="txthae" min="0" max="40"
                       value="<?= isset($matricula) ? $hae : "" ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn <?= isset($matricula) ? "btn-success" : "btn-primary" ?>" 
                       name="<?= isset($matricula) ? "btneditar" : "btnsalvar" ?>" 
                       value="<?= isset($matricula) ? "Editar" : "Cadastrar" ?>">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=docente/consultar" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    //pegar dados do form
    $matricula = filter_input(INPUT_POST, 'txtmatricula', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'chkstatus', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 'txttipo', FILTER_SANITIZE_NUMBER_INT);
    $hae = filter_input(INPUT_POST, 'txthae', FILTER_SANITIZE_NUMBER_INT);

    $doc->setMatricula($matricula);
    $doc->setNome($nome);
    $doc->setStatus($status);
    $doc->setTipo($tipo);
    $doc->setHae($hae);

    //echo $doc->getMatricula() . " - " . $doc->getNome() . " - " . $doc->getStatus() . " - " . $doc->getTipo() . " - " . $doc->getHae();

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($doc->salvar()) {
        ?>
        <div class="alert alert-primary mt-3" role="alert">
            Cadastrado com sucesso
        </div>
        <meta http-equiv="refresh" CONTENT="1;URL=?p=docente/consultar">
        <?php
    }

    //percebam que fechei o php, coloquei html e abri novamente o php...isso é possível e permite que eu trabalhe com php e html (uma das maneiras)
}

if (filter_input(INPUT_POST, 'btneditar')) {
    //pegar dados do form
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'chkstatus', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 'txttipo', FILTER_SANITIZE_NUMBER_INT);
    $hae = filter_input(INPUT_POST, 'txthae', FILTER_SANITIZE_NUMBER_INT);

    $doc->setNome($nome);
    $doc->setStatus($status);
    $doc->setTipo($tipo);
    $doc->setHae($hae);

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($doc->editar()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <meta http-equiv="refresh" CONTENT="2;URL=?p=docente/consultar">
        <?php
    }
}
?>
