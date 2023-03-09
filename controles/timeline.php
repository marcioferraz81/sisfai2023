<?php
include_once 'cabecalho.php';
?>

<div class="container mb-4">    
    <div class="card shadow p-2">
        <div class="row text-center justify-content-center mb-5">

            <div class="col-xl-6 col-lg-8">
                <h3 class="font-weight-bold">Linha do tempo - TG e PTG</h3>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                    <div class="timeline-step">
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                            <div class="inner-circle"></div>
                            <p class="h6 mt-3 mb-1">Etapa 1</p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Cadastrar alunos</p>
                            <a href="?p=aluno/consultar" class="btn btn-link p-2 m-1">clique aqui</a>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                            <div class="inner-circle"></div>
                            <p class="h6 mt-3 mb-1">Etapa 2</p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Criar vínculos</p>
                            <a href="?p=vinculo/consultarptg" class="btn btn-secondary p-2 m-1">PTG</a>
                            <a href="?p=vinculo/consultartg" class="btn btn-danger p-2 pl-3 pr-3 m-1">TG</a>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                            <div class="inner-circle"></div>
                            <p class="h6 mt-3 mb-1">Etapa 3</p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Montar bancas</p>
                            <a href="?p=bancaptg/montar" class="btn btn-secondary p-2 m-1">PTG</a>
                            <a href="?p=bancatg/montar" class="btn btn-danger p-2 pl-3 pr-3 m-1">TG</a>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">
                            <div class="inner-circle"></div>
                            <p class="h6 mt-3 mb-1">Etapa 4</p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Imprimir ATAs</p>
                            <a href="?p=notas/consultarptg" class="btn btn-secondary p-2 m-1">PTG</a>
                            <a href="?p=notas/consultartg" class="btn btn-danger p-2 pl-3 pr-3 m-1">TG</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>