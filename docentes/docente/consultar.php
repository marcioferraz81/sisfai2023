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
<div class="col-sm-12 mb-4">
    <h1 class="mt-3 text-primary">
        Listar Docentes
    </h1>
</div>
<div class="table-responsive-sm mt-4">
    <div class="card shadow">
        <!-- striped é para zebrar as linhas, cada uma com uma cor-->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Matr.</th>
                    <th>Nome</th>
                    
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>  
                <!--foreach aqui BEGIN-->
                <?php
                //estabelecer conversa com a class Categoria
                include_once '../class/Docente.php';
                $doc = new Docente();

                $dados = $doc->consultar();

                foreach ($dados as $mostrar) {
                    ?>
                    <tr>
                        <td><?= $mostrar[0] ?></td>
                        <td><?= $mostrar[1] ?></td>
                        
                        <td><?= $mostrar[3] == 1 ? "Docente" : "Coordenador" ?></td>                       
                    </tr>
                    <?php
                }
                ?>
                <!--foreach aqui END-->
            </tbody>
        </table>
    </div>
</div>


