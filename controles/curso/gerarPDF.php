<?php
include_once 'cabecalho.php';


//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("dompdf/autoload.inc.php");

//Criando a Instancia
$dompdf = new DOMPDF(array('enable_remote' => true));

// Carrega seu HTML

/* ===============COMANDO SQL ================ */

include_once '../class/Curso.php';
$c = new Curso();

$dados = $c->consultar();

foreach ($dados as $mostrar) {
    $nome = $mostrar[2];
    $periodo = $mostrar[1];
    $coord = $mostrar[5];
}

/* =========================FIM SQL================================ */
?>		

<!-- Bootstrap CSS -->

<div class="container">

    <div style="text-align: center;"><img src="https://fatecid.com.br/sisfai/prof/img/logos.png"></div>

    <div style="text-align: center;"><h3>DECLARAÇÃO</h3></div>



    <p class="text-justify">Declaramos para os devidos fins que participaram como membros da Banca Avaliadora da defesa da monografia de Trabalho de Graduação intitulada  <strong>Tema</strong>, do(a) aluno(a) <strong>Aluno</strong>, realizada na Faculdade de Tecnologia de Indaiatuba, no semestre, os seguintes avaliadores:</p>




    <div style="margin-left: 30px;">Prof1 - Presidente da Banca</div>
    <div style="margin-left: 30px;">Prof2 - Professor Convidado</div>
    <div style="margin-left: 30px;">Prof3 - Profissional da área</div>

    <p  style="text-align: center;">Data BAnca.</p>

    <div  style="text-align: center;"><img src="https://fatecid.com.br/sisfai/prof/img/curso.png"></div>



    <div  style="text-align: center;">
        <p><?= $coord ?></p>
        <p>Coordenador do Curso Superior de Tecnologia em <?= $nome ?></p> 

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
