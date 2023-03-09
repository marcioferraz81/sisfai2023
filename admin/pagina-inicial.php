
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
    $a->setId_curso($mostrar[3]);
    $a->setSemestre(date('Y') . $semestre);
    $nr_alunos = $a->contarPorCurso();
    
    $curso = $mostrar[3];
}

$_SESSION['curso'] = $curso;
$contagemtg = $cont->contar($curso);
$contagem = $c->contar($curso);
?>

<div class="row">
    <?php if ($haes != "") { ?>

        <div class="col-md-3 col-sm-12 mt-2">
            <div class="card shadow" style="background: #99ccff;">
                <div class="card-body">
                    <h5 class="card-title">PTG</h5>
                    <p class="card-text">Quantidade de vínculos criados: <strong><?= $contagem ?></strong></p>
                    <a href="?p=vinculo/consultarptg" class="btn btn-primary">Criar vínculos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 mt-2">
            <div class="card shadow" style="background: #ccffcc;">
                <div class="card-body">
                    <h5 class="card-title">TG</h5>
                    <p class="card-text">Quantidade de vínculos criados: <strong><?= $contagemtg ?></strong></p>
                    <a href="?p=vinculotg/consultartg" class="btn btn-success">Criar vínculos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 mt-2">
            <div class="card shadow" style="background: #99ff99;">
                <div class="card-body">
                    <h5 class="card-title"><?= $nome . " | " . $periodo ?></h5>
                    <p class="card-text">HAEs disponíveis: <strong><?= $haes ?></strong></p>
                    <a href="?p=vinculo/consultarptg" class="btn btn-secondary">Criar vínculos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 mt-2 ">
            <div class="card shadow" style="background: #ffffcc;">
                <a href="curso/consultar.php"></a>
                <div class="card-body">
                    <h5 class="card-title">Alunos <?= date('Y') . " - " . $semestre ?></h5>
                    <p class="card-text">Quantidade de alunos: <strong><?= $nr_alunos ?></strong></p>
                    <a href="?p=aluno/consultar" class="btn btn-success">Listar Alunos</a>
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <?php
            include_once 'vinculotg/consultartg.php';
            include_once 'vinculo/consultarptg.php';
            echo "</div>";
        } else {
            ?>
            <div class="col-md-6 col-sm-12 mt-2">
                <div class="card shadow" style="background: #ffffcc;">
                    <a href="curso/consultar.php"></a>
                    <div class="card-body">
                        <h5 class="card-title">Bem vindo professor</h5>
                        <p class="card-text">Verifique os trabalhos</p>
                        <a href="" class="btn btn-success">Listar trabalhos</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

