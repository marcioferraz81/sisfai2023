
<?php
include_once 'cabecalho.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SISFAI - Coordenador</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/timeline.css" rel="stylesheet" type="text/css"/>
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
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">SISFAI Coordenador</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- VAMOS OTIMIZAR NOSSO MENU E CRIAR UM BOTÃO DE SAIR DO ADMIN-->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">                                
                    <li class="nav-item">
                        <a class="nav-link" href="?p=pagina-inicial">Página Inicial</a>
                    </li>     
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Docentes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?p=docente/consultar">Todos</a>
                            <a class="dropdown-item" href="?p=docente/consultarPTG">em PTG</a>
                            <a class="dropdown-item" href="?p=docente/consultarTG">em TG</a>
                        </div>
                    </li>                       

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Alunos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?p=aluno/consultar">Filtro</a>
                            <a class="dropdown-item" href="?p=aluno/consultarAno">Filtro completo</a>
                            <a class="dropdown-item" href="?p=aluno/pesquisarIndefinidos">Indefinidos</a>
                            <a class="dropdown-item" href="?p=aluno/pesquisarSemVinculo">Sem vínculo PTG/TG</a>
                        </div>
                    </li>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Vínculos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?p=vinculo/consultarptg">PTG</a>
                            <a class="dropdown-item" href="?p=vinculotg/consultartg">TG</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Montar bancas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?p=bancaptg/montar">PTG</a>
                            <a class="dropdown-item" href="?p=bancatg/montar">TG</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="?p=gerarAta">Gerar ATAs</a>
                    </li> 


                    <li class="nav-item">
                        <a class="nav-link" href="?p=aluno/ptgPassado">Verificar PTGs</a>
                    </li>   
                    
                    <li class="nav-item">
                        <a class="nav-link" href="?p=usuario/alterarSenha">Alterar Senha</a>
                    </li>    
                </ul>
            </div>

            <a href="logout.php" class="btn btn-dark float-right"><i class="bi bi-box-arrow-right"></i></a>

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
        <script src="../js/perguntar.js"></script>
        <script type="text/javascript">
                                    function closePrint() {
                                        document.body.removeChild(this.__container__);
                                    }

                                    function setPrint() {
                                        this.contentWindow.__container__ = this;
                                        this.contentWindow.onbeforeunload = closePrint;
                                        this.contentWindow.onafterprint = closePrint;
                                        this.contentWindow.focus(); // Required for IE
                                        this.contentWindow.print();
                                    }

                                    function printPage(sURL) {
                                        var oHiddFrame = document.createElement("iframe");
                                        oHiddFrame.onload = setPrint;
                                        oHiddFrame.style.position = "fixed";
                                        oHiddFrame.style.right = "0";
                                        oHiddFrame.style.bottom = "0";
                                        oHiddFrame.style.width = "0";
                                        oHiddFrame.style.height = "0";
                                        oHiddFrame.style.border = "0";
                                        oHiddFrame.src = sURL;
                                        document.body.appendChild(oHiddFrame);
                                    }
        </script>

    </body>
</html>


