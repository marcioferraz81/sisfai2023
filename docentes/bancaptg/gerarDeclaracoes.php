<?php
$vinculo = filter_input(INPUT_GET, 'vinculo');
$semestre = filter_input(INPUT_GET, 'semestre');
$matricula = $_SESSION['matricula'];
include_once '../class/BancaPTG.php';
$b = new BancaPTG();
$b->setProfessor($matricula);
$dados = $b->gerarPDF_varios($semestre);

include_once '../class/Assinatura.php';
$ass = new Assinatura();

foreach ($dados as $mostrar) {
    $aluno = $mostrar[0];
    $tema = $mostrar[2];
    $coord = $mostrar[3];
    $mat_coord = $mostrar['matr_coord'];
    $curso = $mostrar[4];
    $vinculo = $mostrar['vinculoPTG'];
    $dupla = $mostrar['dupla'];
    $dupla = " / " . $dupla;
    ?>
    <div class="container-fluid mb-3" style="width: 90%;">

        <div class="text-center"><img src="https://fatecid.com.br/sisfai2022/assinatura/logos.png"></div>
        <br><br>
        <div class="text-center mb-3"><h3>DECLARAÇÃO PTG</h3></div>
        <br><br>


        <p class="text-justify mb-4">
            Declaramos para os devidos fins que participaram como membros da Banca Avaliadora da defesa da monografia de Trabalho de Graduação intitulada <strong><?= $tema ?></strong>, do(s) aluno(s) <strong><?= $aluno ?></strong><strong><?= ($dupla != " / ") ? $dupla : "" ?></strong>, realizada na Faculdade de Tecnologia de Indaiatuba, no <?= substr($semestre, -1) ?>º semestre de <?= substr($semestre, 0, 4) ?>, os seguintes avaliadores:
        </p>

        <br><br>

        <?php
        $b->setVinculoPTG($vinculo);
        $dados2 = $b->gerarPDF();

        foreach ($dados2 as $mostrar) {
            switch ($mostrar[8]) {
                case "orientador":
                    ?>
                    <div style="margin-left: 30px;">Prof <?= $mostrar[1] ?> - Presidente da Banca</div>
                    <?php
                    break;
                case "área":
                    ?>
                    <div style="margin-left: 30px;">Prof <?= $mostrar[1] ?> - Professor da Área</div>
                    <?php
                    break;
                case "convidado":
                    ?>
                    <div style="margin-left: 30px;">Prof <?= $mostrar[1] ?> - Professor Convidado</div>
                    <?php
                    break;
                default:
                    $texto_banca = "";
                    ?>
                    <div style="margin-left: 30px;">Prof <?= $mostrar[1] ?> </div>
                    <?php
                    break;
            }
        }


        $ass->setMatricula($mat_coord);
        $dados3 = $ass->pesquisarPorID();
        foreach ($dados3 as $mostrar) {
            $imagem = $mostrar['imagem'];
        }
        ?>
        <br><br>
        <br><br>
        <br><br>
        <p class="text-center mt-5"><?= date('d/m/Y') ?></p>

        <div class="text-center"><img src="https://fatecid.com.br/sisfai2022/assinatura/<?= $imagem ?>" style="width: 150px;"></div>

        <div  style="text-align: center;"  class="mb-5">
            <p><?= $coord ?></p>
            <p>Coordenador do Curso Superior de Tecnologia em <br><?= $curso ?></p> 
        </div>
    </div>

    <!--quebra de linha-->
    <div style="page-break-before: always;"> </div>
    <?php
}