<?php
include_once 'cabecalho.php';

$ra = $_SESSION['ra'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SISFAI - aluno</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

        <style>
            *{
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body class="bg-light">
         
            <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
                <a class="navbar-brand" href="#">SISFAI (RA: <?= $ra ?>)</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alterna navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- VAMOS OTIMIZAR NOSSO MENU E CRIAR UM BOTÃO DE SAIR DO ADMIN-->
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">                                
                        <li class="nav-item">
                            <a class="nav-link" href="?p=pagina-inicial">Página Inicial</a>
                        </li>                       
                        <li class="nav-item">
                            <a class="nav-link" href="?p=aluno/editar">Atualizar cadastro</a>
                        </li>      
                        <li class="nav-item">
                            <a class="nav-link" href="?p=notas/listar">Notas da banca</a>
                        </li>      
                        <li class="nav-item">
                            <a class="nav-link" href="?p=aluno/alterarSenha">Alterar Senha</a>
                        </li>    
                    </ul>
                </div>

                <a href="logout.php" class="btn btn-light float-right">Sair</a>

                <!-- pronto, vamos ver como ficou-->
            </nav>
       

        <div class="container">            
            <div class="row mt-3">
                <div class="col-md-12">
                    <?php
                    $pagina = filter_input(INPUT_GET, 'p');

                    if ($pagina == '' || empty($pagina) || $pagina == 'index' || $pagina == 'index.php') {
                        include_once 'pagina-inicial.php';
                    } else {
                        if (file_exists($pagina . '.php')) {
                            include_once $pagina . '.php';
                        } else {
                            echo '<div class="col-12">&nbsp;</div>'
                            . '<div class="alert alert-danger" role="alert">'
                            . '<h3>Erro 404</h3>'
                            . '<p>Página não encontrada!</p>'
                            . '</div>';
                        }
                    }
                    ?>
                </div>
            </div><!--fim linha conteúdo-->

        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="../js/script.js"></script>
    </body>
</html>


