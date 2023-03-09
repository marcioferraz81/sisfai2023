
<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$id = filter_input(INPUT_GET, 'id');

//estabelecer conversa com a class Categoria
include_once '../class/Curso.php';
$c = new Curso();

if (isset($id)) {
    $c->setId($id);
    $dados = $c->consultarPorID();
    foreach ($dados as $mostrar) {
        $nome = $mostrar[2];
        $periodo = $mostrar[1];
        $matricula_coord = $mostrar[3];
    }
}
?>


<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($id) ? "Editar" : "Cadastrar" ?> Curso
</h1>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                ID Curso
            </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="txtid" name="txtid"  
                       value="<?= isset($id) ? $id : "" ?>" <?= isset($id) ? "disabled" : "" ?>>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Nome
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtnome" name="txtnome" placeholder="Nome de Curso" 
                       value="<?= isset($id) ? $nome : "" ?>">
            </div>
        </div>        

        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Período
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selperiodo" id="selperiodo" required>
                    <option value="Manhã" <?= isset($id) && $periodo == "Manhã" ? "selected" : "" ?>>Manhã</option>
                    <option value="Tarde" <?= isset($id) && $periodo == "Tarde" ? "selected" : "" ?>>Tarde</option>
                    <option value="Noite" <?= isset($id) && $periodo == "Noite" ? "selected" : "" ?>>Noite</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Coordenador
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selcoord" id="selcoord" required>
                    <?php
                    include_once '../class/Docente.php';
                    $doc = new Docente();
                    $consulta = $doc->consultar();
                    foreach ($consulta as $mostrar) {
                        ?>
                        <option value="<?= $mostrar[0] ?>" <?= isset($id) && $matricula_coord == $mostrar[0] ? "selected" : "" ?>><?= $mostrar[1] ?></option>
                        <?php
                    }
                    ?>                
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn <?= isset($id) ? "btn-success" : "btn-primary" ?>" 
                       name="<?= isset($id) ? "btneditar" : "btnsalvar" ?>" 
                       value="<?= isset($id) ? "Editar" : "Cadastrar" ?>">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=curso/consultar" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    //pegar dados do form
    $id = filter_input(INPUT_POST, 'txtid', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $periodo = filter_input(INPUT_POST, 'selperiodo', FILTER_SANITIZE_STRING);
    $coordenador = filter_input(INPUT_POST, 'selcoord', FILTER_SANITIZE_NUMBER_INT);

    $c->setId($id);
    $c->setNome($nome);
    $c->setPeriodo($periodo);
    $c->setMatricula_coord($coordenador);

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($c->salvar()) {
        ?>
        <div class="alert alert-primary mt-3" role="alert">
            Cadastrado com sucesso
        </div>
        <meta http-equiv="refresh" CONTENT="2;URL=?p=curso/consultar">
        <?php
    }

    //percebam que fechei o php, coloquei html e abri novamente o php...isso é possível e permite que eu trabalhe com php e html (uma das maneiras)
}

if (filter_input(INPUT_POST, 'btneditar')) {
    //pegar dados do form
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $periodo = filter_input(INPUT_POST, 'selperiodo', FILTER_SANITIZE_STRING);
    $coordenador = filter_input(INPUT_POST, 'selcoord', FILTER_SANITIZE_NUMBER_INT);

   // $c->setId($id);
    $c->setNome($nome);
    $c->setPeriodo($periodo);
    $c->setMatricula_coord($coordenador);

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($c->editar()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <meta http-equiv="refresh" CONTENT="2;URL=?p=curso/consultar">
        <?php
    }
}
?>
