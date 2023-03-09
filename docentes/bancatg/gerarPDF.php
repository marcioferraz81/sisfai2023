<?php

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
include_once("dompdf/autoload.inc.php");

//Criando a Instancia
$dompdf = new DOMPDF(array('enable_remote' => true));

// Carrega seu HTML

/* ===============COMANDO SQL ================ */

$vinculo = filter_input(INPUT_GET, 'vinculo');

include_once '../class/BancaTG.php';
$b = new BancaTG();
$b->setVinculoTG($vinculo);
$dados = $b->gerarPDF();

foreach ($dados as $mostrar) {
    $aluno = $mostrar[0];
    $tema = $mostrar[2];
    $coord = $mostrar[3];
    $curso = $mostrar[4];
    $matricula = $mostrar['matricula'];
}

include_once '../class/Assinatura.php';
$ass = new Assinatura();
$ass->setMatricula($matricula);
$dados2 = $ass->pesquisarPorID();
foreach ($dados2 as $mostrar) {
    $imagem = $mostrar[2];
}

/* =========================FIM SQL================================ */
?>		

<!-- Bootstrap CSS -->

<div class="container" style="margin-top: -350px;">

    <div style="text-align: center;"><img src="https://fatecid.com.br/sisfai2022/assinatura/logos.png"></div>
    <br><br>
    <div style="text-align: center;"><h3>DECLARAÇÃO</h3></div>
    <br><br>


    <p class="text-justify">Declaramos para os devidos fins que participaram como membros da Banca Avaliadora da defesa da monografia de Trabalho de Graduação intitulada <strong><?= $tema ?></strong>, do(a) aluno(a) <strong><?= $aluno ?></strong>, realizada na Faculdade de Tecnologia de Indaiatuba, no <?= (date('m') < 7 ? 1 : 2) ?>º semestre, os seguintes avaliadores:</p>

    <br><br>

    <?php
    foreach ($dados as $mostrar) {
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
    ?>
    <br><br>
    <p  style="text-align: center;"><?= date('d/m/Y') ?></p>

    <div  style="text-align: center;"><img src="https://fatecid.com.br/sisfai2022/assinatura/<?= $imagem ?>" style="width: 150px;"></div>
    



    <div  style="text-align: center;">
        <p><?= $coord ?></p>
        <p>Coordenador do Curso Superior de Tecnologia em <br><?= $curso ?></p> 

    </div>

</div>


<?php
$dompdf->load_html(ob_get_clean());

//Renderizar o html
$dompdf->render();

//Exibibir a página
$dompdf->stream(
        "Declaração_TG_ANO.pdf",
        array(
            "Attachment" => false //Para realizar o download somente alterar para true
        )
);
