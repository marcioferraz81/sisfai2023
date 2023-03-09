<?php
include_once 'cabecalho.php';
?>

<?php
//capturar id da url
$ra = filter_input(INPUT_GET, 'ra');
$link = filter_input(INPUT_GET, 'link');
//estabelecer conversa com a class Categoria

$nome_do_curso = $_SESSION['nome_curso'];
$id_do_curso = $_SESSION['id_curso'];

include_once '../class/Aluno.php';
include_once '../class/Curso.php';
$curso = new Curso();
$consulta = $curso->consultar();
$al = new Aluno();
if (isset($ra)) {
    $al->setRa($ra);
    $dados = $al->consultarPorID();
    foreach ($dados as $mostrar) {
        $semestre = $mostrar[6];
        $curso = $mostrar[8];
        $nome_curso = $mostrar[11];
        $ra = $mostrar[0];
        $nome = $mostrar[4];
        $tipo_trabalho = $mostrar[9];
    }
}
?>

<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($ra) ? "Editar" : "Cadastrar" ?> Aluno
</h1>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Ano
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selano" id="selano" required >
                    <option selected disabled>Ano</option>
                    <?= isset($ra) ? "<option value='" . substr($semestre, 0, 4) . "' selected>" . substr($semestre, 0, 4) . "</option>" : "" ?>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>                
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Semestre
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="selsemestre" id="selsemestre" required >
                    <option selected disabled>Semestre</option>
                    <?= isset($ra) ? "<option value='" . substr($semestre, 4, 1) . "' selected>" . substr($semestre, 4, 1) . "º semestre</option>" : "" ?>
                    <option value="1">1º semestre</option>
                    <option value="2">2º semestre</option>            
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Tipo de trabalho (ptg ou tg)
            </label>
            <div class="col-sm-10">
                <select class="form-control" aria-label="Default select example" name="seltipotrabalho" id="seltipotrabalho" required >
                    <option selected disabled>Tipo de trabalho</option>
                    <?= isset($ra) ? "<option value='" . $tipo_trabalho . "' selected>" . $tipo_trabalho . "</option>" : "" ?>
                    <option value="ptg">PTG</option>
                    <option value="tg">TG</option>            
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">            
                Curso
            </label>
            <div class="col-sm-10">
                <p><?= $nome_do_curso ?></p>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                RA
            </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="txtra" name="txtra"  
                       value="<?= isset($ra) ? $ra : "" ?>" <?= isset($ra) ? "disabled" : "" ?>>
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Nome
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtnome" name="txtnome" placeholder="Nome de aluno" 
                       value="<?= isset($ra) ? $nome : "" ?>">
            </div>
        </div>     

        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn <?= isset($ra) ? "btn-success" : "btn-primary" ?>" 
                       name="<?= isset($ra) ? "btneditar" : "btnsalvar" ?>" 
                       value="<?= isset($ra) ? "Editar" : "Cadastrar" ?>">               
            </div>
            <!-- faltou um link aqui-->

            <?php
            if ($link == 1) {
                echo '<a href="?p=aluno/consultar" class="btn btn-danger">Voltar</a>';
            } else if ($link == 2) {
                echo '<a href="?p=aluno/pesquisarIndefinidos" class="btn btn-danger">Voltar</a>';
            }
            ?>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
    $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
    $curso = filter_input(INPUT_POST, 'selcurso', FILTER_SANITIZE_NUMBER_INT);
    $ra = filter_input(INPUT_POST, 'txtra', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $tipotrab = filter_input(INPUT_POST, 'seltipotrabalho', FILTER_SANITIZE_STRING);

    //$ano = date('Y');
    //$semestre = date('m') < 7 ? 1 : 2;

    $al->setId_curso($id_do_curso);
    $al->setSemestre($ano . $semestre);
    $al->setRa($ra);
    $al->setNome($nome);
    $al->setTipo_trabalho($tipotrab);
    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($al->salvar()) {
        ?>
        <div class="alert alert-primary mt-3" role="alert">
            Cadastrado com sucesso
        </div>
        <?php
        if ($link == 1) {
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=aluno/consultar">';
        } else if ($link == 2) {
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=aluno/pesquisarIndefinidos">';
        }
        ?>
        <?php
    }
}
if (filter_input(INPUT_POST, 'btneditar')) {

    //$al = new Aluno();
    //pegar dados do form
    $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
    $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
    $curso = filter_input(INPUT_POST, 'selcurso', FILTER_SANITIZE_NUMBER_INT);
    //$ra = filter_input(INPUT_POST, 'txtra', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $tipotrab = filter_input(INPUT_POST, 'seltipotrabalho', FILTER_SANITIZE_STRING);

    $al->setId_curso($id_do_curso);
    $al->setSemestre($ano . $semestre);
    $al->setRa($ra);
    $al->setNome($nome);
    $al->setTipo_trabalho($tipotrab);

    //echo $al->getTipo_trabalho();
    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($al->editar()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <?php
        if ($link == 1) {
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=aluno/consultar">';
        } else if ($link == 2) {
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=aluno/pesquisarIndefinidos">';
        }
        ?>

        <?php
        //echo $al->getId_curso() . " - " . $al->getSemestre(). " - " . $al->getRa() . $al->getNome();
    }
}
?>

