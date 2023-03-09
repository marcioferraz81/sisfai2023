<?php
include_once 'cabecalho.php';
?>

<?php
include_once '../class/Aluno.php';
$al = new Aluno();
$al->setRa($ra);
$dados = $al->consultarPorID();
foreach ($dados as $mostrar) {
    $email = $mostrar['email_aluno'];
    $fone = $mostrar['fone_aluno'];
}
?>

<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($ra) ? "Editar" : "" ?> Aluno com RA: <?= $ra ?>
</h1>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->        

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                E-mail
            </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="E-mail do aluno" 
                       value="<?= isset($ra) ? $email : "" ?>">
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Telefone
            </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="txtfone" name="txtfone" placeholder="Fone (somente números e sem espaço)" 
                       value="<?= isset($ra) ? $fone : "" ?>">
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
            <a href="?p=pagina-inicial" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {

    //$al = new Aluno();
    //pegar dados do form
    $fone = filter_input(INPUT_POST, 'txtfone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);

    $al->setEmail($email);
    $al->setFone($fone);
    
    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($al->editarAluno()) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <?php
        //echo $al->getId_curso() . " - " . $al->getSemestre(). " - " . $al->getRa() . $al->getNome();
    }
}
?>

