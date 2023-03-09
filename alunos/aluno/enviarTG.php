<?php
include_once 'cabecalho.php';
?>

<?php
$ra = $_SESSION['ra'];
include_once '../class/VinculoTG.php';
$trab = new VinculoTG();
$trab->setAluno($ra);
$dados = $trab->pesquisarPorRA();

foreach ($dados as $mostrar) {
    $id_vinculo = $mostrar['id_vinculoTG'];
    $titulo = $mostrar['titulo'];
    $video = $mostrar['link_video'];
    $drive = $mostrar['link_drive'];
}
?>

<h1 class="mt-3 text-primary"><!--como fizemos em consultar-->
    <?= isset($ra) ? "Enviar TG" : "" ?> RA: <?= $ra ?>
</h1>

<div class="card shadow mt-3"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <!-- m-3 determinei todas as bordas, não mudei o form-->   
        
        <div class="form-group row">            
            <label for="inputText" class="col-sm-3 col-form-label">                
                Confirme seu RA (obrigatório)
            </label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="txtra" name="txtra" required>
            </div>
        </div>


        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Título
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txt_titulo" name="txt_titulo" placeholder="Título do trabalho" 
                       value="<?= isset($titulo) ? $titulo : "" ?>" maxlength="100">
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Link do Vídeo
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txt_video" name="txt_video" placeholder="Link do vídeo do youtube" 
                       value="<?= isset($video) ? "https://www.youtube.com/watch?v=" . $video : "" ?>" maxlength="100">
            </div>
        </div>

        <div class="form-group row">            
            <label for="inputText" class="col-sm-2 col-form-label">                
                Link do Drive
            </label>
            <div class="col-sm-10">
                <input type="url" class="form-control" id="txt_drive" name="txt_drive" placeholder="Link do drive (onedrive, google drive)" 
                       value="<?= isset($drive) ? $drive : "" ?>" maxlength="255">
            </div>
        </div>



        <div class="form-group row">
            <div class="col-sm-10">            
                <input type="submit" 
                       class="btn <?= isset($ra) ? "btn-primary" : "btn-primary" ?>" 
                       name="<?= isset($ra) ? "btneditar" : "btnsalvar" ?>" 
                       value="<?= isset($ra) ? "Postar trabalho" : "Postar trabalho" ?>">               
            </div>
            <!-- faltou um link aqui-->
            <a href="?p=pagina-inicial" class="btn btn-danger">Voltar</a>
        </div>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    $ra_form = filter_input(INPUT_POST, 'txtra', FILTER_SANITIZE_NUMBER_INT);
    $url_video = str_replace("https://youtu.be/", "", filter_input(INPUT_POST, 'txt_video', FILTER_SANITIZE_STRING));
    $url_video = str_replace("https://www.youtube.com/watch?v=", "", $url_video);

    $titulo = filter_input(INPUT_POST, 'txt_titulo', FILTER_SANITIZE_STRING);
    $link_drive = filter_input(INPUT_POST, 'txt_drive', FILTER_SANITIZE_STRING);

    $ano = date('Y');
    $semestre = date('m') < 7 ? 1 : 2;
    $trab->setAluno($ra_form);
    $trab->setSemestre($ano . $semestre);

    //efetuar o cadastro, com msg (com alert Bootstrap) 
    if ($trab->enviarTrabalho($titulo, $url_video, $link_drive, $id_vinculo)) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado com sucesso
        </div>
        <meta http-equiv="refresh" CONTENT="0.1;URL=?p=pagina-inicial">
        <?php
    }
}


