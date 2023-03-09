<?php
include_once 'cabecalho.php';
?>

<?php
//estabelecer conversa com a class Categoria
include_once '../class/VinculoPTG.php';
$c = new VinculoPTG();

include_once '../class/VinculoTG.php';
$cont = new VinculoTG();

include_once '../class/Aluno.php';
$a = new Aluno();

include_once '../class/Curso.php';
$cu = new Curso();

$semestre = date('m') < 7 ? 1 : 2;

$matricula = $_SESSION['matricula'];
$haes = "";
$curso = "";
$nome = "";

$cu->setMatricula_coord($matricula);
$contarHAE = $cu->contarHAE();
foreach ($contarHAE as $mostrar) {
    $haes = $mostrar[0];
    $periodo = $mostrar[1];
    $nome = $mostrar[2];
    $_SESSION['nome_curso'] = $nome;
    $_SESSION['id_curso'] = $mostrar[3];
    $a->setId_curso($mostrar[3]);
    $a->setSemestre(date('Y') . $semestre);
    $nr_alunos = $a->contarPorCurso();

    $curso = $mostrar[3];
}

$_SESSION['curso'] = $curso;
$contagemtg = $cont->contar($curso);
$contagem = $c->contar($curso);

include_once 'timeline.php';
?>


<div class="container mb-4">  
    <div class="row">
<?php if ($haes != "") { ?>

        <div class="col-md-3 col-sm-12 mt-0" >
            <div class="card shadow" style="height: 120px; background: #ccccff;">
                    <div class="card-body">
                        <h6 class="card-title">PTG</h6>
                        <p class="card-text">Quantidade de vínculos criados: <strong><?= $contagem ?></strong></p>

                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12 mt-0" >
                <div class="card shadow" style="height: 120px; background: #ccffcc;">
                    <div class="card-body">
                        <h6 class="card-title">TG</h6>
                        <p class="card-text">Quantidade de vínculos criados: <strong><?= $contagemtg ?></strong></p>
                      
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12 mt-0">
                <div class="card shadow" style="height: 120px; background: #ffcccc;">
                    <div class="card-body">
                        <h6 class="card-title"><?= $nome . " | " . $periodo ?></h6>
                        <p class="card-text">HAEs disponíveis: <strong><?= $haes ?></strong></p>
                  
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12 mt-0 " >
                <div class="card shadow" style="height: 120px; background: #ffffcc;">
                    <a href="curso/consultar.php"></a>
                    <div class="card-body">
                        <h6 class="card-title">Ano: <?= date('Y') . " - " . $semestre . "º semestre" ?></h6>
                        <p class="card-text">Quantidade de alunos: <strong><?= $nr_alunos ?></strong></p>
         
                    </div>
                </div>
            </div>


            <div class="row mt-4">
    <?php
    //include_once 'vinculotg/consultartg.php';
    //include_once 'vinculo/consultarptg.php';
    echo "</div>";
} else {
    ?>
                <div class="col-md-6 col-sm-12 mt-2">
                    <div class="card shadow" style="background: #ffffcc;">
                        <a href="curso/consultar.php"></a>
                        <div class="card-body">
                            <h6 class="card-title">Bem vindo professor</h6>
                            <p class="card-text">Verifique os trabalhos</p>
                        
                        </div>
                    </div>
                </div>
<?php } ?>
        </div>

    </div>