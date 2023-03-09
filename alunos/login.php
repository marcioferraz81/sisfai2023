<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SISFAI - aluno</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <!-- Estilos customizados para esse template -->
        <link href="../css/signin.css" rel="stylesheet">
    </head>

    <body class="text-center bg-light">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-4 col-sm-12">&nbsp;</div>
                <div class="col-md-4 col-sm-12">
                    <form class="form-signin" method="post">

                        <h1 class="h3 mb-3 font-weight-normal">SISFAI <br>Aluno</h1>
                        <div class="col-sm-12">
                            <div class="checkbox mb-3">
                                <label for="inputEmail" class="sr-only">RA</label>
                                <input type="number" id="inputEmail" name="txtra" class="form-control" required autofocus>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="checkbox mb-3">
                                <label for="inputPassword" class="sr-only">Senha</label>
                                <input type="password" id="inputPassword" name="txtsenha" class="form-control" placeholder="Senha" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" name="btnacessar" class="btn btn-lg btn-primary btn-block" valeu="Login">
                            <a href="../index.php" class="btn btn-lg btn-link btn-block"><< Voltar</a>
                            <p class="mt-2 mb-3 text-muted">&copy; 2022</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


<?php
if (filter_input(INPUT_POST, 'btnacessar')) {
//recebendo dados do form
    $ra = filter_input(INPUT_POST, 'txtra', FILTER_SANITIZE_NUMBER_INT);
    $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);

    //acesso a table no MySQL
    include_once '../class/Usuario.php';
    $user = new Usuario();

    $user->setMatricula(trim($ra));
    $user->setSenha(trim($senha));

    if (count($user->consultarAluno()) <= 0) {
        echo '<div class="container">'
        . '<div class="alert alert-danger" role="alert">'
        . '<h3>RA e/ou senha incorreta(s)</h3>'
        . '<p>Verifique seu RA e senha!</p>'
        . '</div>'
        . '</div>';
    } else {
        //echo "sucesso";
        foreach ($user->consultarAluno() as $mostrar) {
            $nivel = $mostrar['tipoUsuario_aluno'];
            $ra = $mostrar['ra_aluno'];
            $tipo = $mostrar['tipo_trabalho'];
        }
        session_start();
        $_SESSION['acesso_aluno'] = '9c13e3196f335ab2378e786ce650c0c38d70fd21';
        $_SESSION['nivel_aluno'] = $nivel;
        $_SESSION['tipo_trabalho'] = $tipo;
        $_SESSION['ra'] = trim($ra);

        //redireciona página
        header("Location: index.php");
    }
}



