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

<?php
//$vinculo = filter_input(INPUT_GET, 'vinculo');
$id = filter_input(INPUT_GET, 'id');
$nota = filter_input(INPUT_GET, 'nota');

if (isset($id)) {
    include_once '../class/BancaTG.php';
    $b = new BancaTG();
    $b->setCodBanca($id);
    $dados = $b->pesquisarTerceiraEtapaVinculo();
    foreach ($dados as $mostrar) {
        $tipo = $mostrar['tipoBanca'];
        $comentario = $mostrar['comentario'];
        $titulo = $mostrar['titulo'];
        $aluno = $mostrar['nome_aluno'];
        $vinculo = $mostrar['vinculoTG'];

        $notaEscrita_01 = $mostrar['notaEscrita_01'];
        $notaEscrita_02 = $mostrar['notaEscrita_02'];
        $notaEscrita_03 = $mostrar['notaEscrita_03'];
        $notaEscrita_04 = $mostrar['notaEscrita_04'];
        $notaEscrita_05 = $mostrar['notaEscrita_05'];
        $notaEscrita_06 = $mostrar['notaEscrita_06'];
        $notaEscrita_07 = $mostrar['notaEscrita_07'];

        $notaOral_01 = $mostrar['notaOral_01'];
        $notaOral_02 = $mostrar['notaOral_02'];
        $notaOral_03 = $mostrar['notaOral_03'];
        $notaOral_04 = $mostrar['notaOral_04'];
        $notaOral_05 = $mostrar['notaOral_05'];
        $notaOral_06 = $mostrar['notaOral_06'];
        $notaOral_07 = $mostrar['notaOral_07'];

        $notaFormatacao_01 = $mostrar['notaFormatacao_01'];
        $notaFormatacao_02 = $mostrar['notaFormatacao_02'];
        $notaFormatacao_03 = $mostrar['notaFormatacao_03'];
        $notaFormatacao_04 = $mostrar['notaFormatacao_04'];
        $notaFormatacao_05 = $mostrar['notaFormatacao_05'];
        $notaFormatacao_06 = $mostrar['notaFormatacao_06'];
        $notaFormatacao_07 = $mostrar['notaFormatacao_07'];
        $notaFormatacao_08 = $mostrar['notaFormatacao_08'];
        $notaFormatacao_09 = $mostrar['notaFormatacao_09'];
        $notaFormatacao_10 = $mostrar['notaFormatacao_10'];
    }
}
?>

<div class="col-sm-12 mb-4">
    <div class="card shadow mb-4">
        <h4 class="text-center font">Avaliação de Trabalho de Graduação (<?= $tipo ?>) 
            <a href="?p=notas/listar" class="btn btn-danger m-2">Cancelar</a>
        </h4>
        <hr class="text-muted mt-1">
        <h5 class="text-center font">Aluno(a): <?= $aluno ?></h5>
        <h5 class="text-center font">Tema:  <?= $titulo ?></h5>
        <hr class="text-muted mt-1">
        <form method="post" id="notas" action="">

            <div class="table-responsive-sm">
                <table class="table table-hover table-sm p-3">
                    <tbody>

                        <?php if ($tipo == "orientador") { ?>
                            <!--=============FORMULARIO DE FORMATAÇÃO============  -->
                            <tr class="mt-4">
                                <td colspan="3" style="background: #ffff99;">
                                    <h5 class="text-center">TABELA PARA AVALIAÇÃO DE FORMATAÇÃO (APENAS ORIENTADOR)</h5>
                                </td>
                            </tr>
                            <tr class="thead-light">
                                <th class="font-weight-bolder text-center">Item</th>
                                <th class="font-weight-bolder text-center">Pontos até</th>
                                <th class="font-weight-bolder text-center">Nota</th>
                            </tr>

                            <tr>
                                <td class="text-left">1. Capa</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao01" class="form-control" value="<?= $notaFormatacao_01 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">2. Sumário</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao02" class="form-control" value="<?= $notaFormatacao_02 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">3. Resumo</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao03" class="form-control" value="<?= $notaFormatacao_03 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>

                            <tr>
                                <td class="text-left">4. Numeração de páginas</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao04" class="form-control" value="<?= $notaFormatacao_04 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">5. Títulos e subtítulos</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao05" class="form-control" value="<?= $notaFormatacao_05 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">6. Espaçamento e margens</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao06" class="form-control" value="<?= $notaFormatacao_06 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">7. Nota de rodapé</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao07" class="form-control" value="<?= $notaFormatacao_07 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">8. Figuras, gráficos e tabelas</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao08" class="form-control" value="<?= $notaFormatacao_08 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">9.  Citação bibliográfica</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao09" class="form-control" value="<?= $notaFormatacao_09 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>
                            <tr>
                                <td class="text-left">10. Referência</td>
                                <td class="text-center">1.0</td>
                                <td class="text-center"><input type="number" name="formatacao10" class="form-control" value="<?= $notaFormatacao_10 ?>" max="1" min="0" step="0.1" required></td>
                            </tr>                           

                        <?php } ?>
                        <!--=============FORMULARIO DE ESCRITA============  -->
                        <tr class="mt-4">
                            <td colspan="3" style="background: #ffff99;">
                                <h5 class="text-center">TABELA PARA AVALIAÇÃO DA APRESENTAÇÃO ESCRITA</h5>
                            </td>
                        </tr>
                        <tr class="thead-light">
                            <th class="font-weight-bolder text-center">Pergunta</th>
                            <th class="font-weight-bolder text-center">Pontos até</th>
                            <th class="font-weight-bolder text-center">Nota</th>
                        </tr>
                        <tr>
                            <td class="text-left">1. Analise o Sumário. Conforme apresentado na monografia,representa um convite para a leitura da pesquisa? Traz uma orientação clara e objetiva para o leitor/avaliador do trabalho?</td>
                            <td class="text-center">0.5</td>
                            <td class="text-center"><input type="number" name="escrita01" class="form-control" value="<?= $notaEscrita_01 ?>" max="0.5" min="0" step="0.1" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">2. O resumo traz o objetivo, a justificativa, a metodologia e os resultados alcançados? </td>
                            <td class="text-center">0.5</td>
                            <td class="text-center"><input type="number"  max="0.5" min="0" step="0.1" name="escrita02" class="form-control" value="<?= $notaEscrita_02 ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">3. O objetivo e a justificativa estão de acordo com as regras básicas de um trabalho de conclusão de curso?</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number"  max="1" min="0" step="0.1" name="escrita03" class="form-control" value="<?= $notaEscrita_03 ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-left" >4. A introdução e a conclusão da monografia estabelecem conexões: uma proposta de trabalho e a sua implementação?</td>
                            <td class="text-center">2</td>
                            <td class="text-center"><input type="number" name="escrita04" class="form-control" value="<?= $notaEscrita_04 ?>"  max="2" min="0" step="0.1" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">5. A Fundamentação teórica / Revisão bibliográfica está adequada e pertinente à área desta pesquisa?</td>
                            <td class="text-center">2</td>
                            <td class="text-center"><input type="number" max="2" min="0" step="0.1" name="escrita05" class="form-control" value="<?= $notaEscrita_05 ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">6. A Fundamentação teórica / Revisão bibliográfica é explorada na aplicação e na análise de dados? </td>
                            <td class="text-center">2.5</td>
                            <td class="text-center"><input type="number" max="2.5" min="0" step="0.1" name="escrita06" class="form-control" value="<?= $notaEscrita_06 ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">7. A monografia traz uma contribuição relevante para a área de sua	aplicação? </td>
                            <td class="text-center">1.5</td>
                            <td class="text-center"><input type="number" max="1.5" min="0" step="0.1" name="escrita07" class="form-control" value="<?= $notaEscrita_07 ?>" required></td>
                        </tr>

                        <tr class="mt-4">
                            <td colspan="3" style="background: #ffff99;">
                                <h5 class="text-center font">TABELA PARA AVALIAÇÃO DA APRESENTAÇÃO ORAL </h5>
                            </td>
                        </tr>
                        <tr class="thead-light">
                            <th class="font-weight-bolder text-center">Pergunta</th>
                            <th class="font-weight-bolder text-center">Pontos até</th>
                            <th class="font-weight-bolder text-center">Nota</th>

                        </tr>
                        <tr>
                            <td class="text-left">1. Apresentação / Postura do Aluno</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number" max="1" min="0" step="0.1" name="oral01" class="form-control" value="<?= $notaOral_01 ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-left">2. Encerramento dentro do Tempo Previsto ( 10 a 20 min) </td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number" max="1" min="0" step="0.1" name="oral02" class="form-control" value="<?= $notaOral_02 ?>"  required></td>
                        </tr>
                        <tr>
                            <td class="text-left">3. Adequação da Apresentação em Relação aos Objetivos Propostos</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number" max="1" min="0" step="0.1" name="oral03" class="form-control" value="<?= $notaOral_03 ?>"  required></td>
                        </tr>
                        <tr>
                            <td class="text-left">4. Domínio do Assunto</td>
                            <td class="text-center">3</td>
                            <td class="text-center"><input type="number" max="3" min="0" step="0.1" name="oral04" class="form-control" value="<?= $notaOral_04 ?>"  required></td>
                        </tr>
                        <tr>
                            <td class="text-left">5. Desenvolvimento do Tema em Sequência Lógica e Continuidade Natural</td>
                            <td class="text-center">2</td>
                            <td class="text-center"><input type="number" max="2" min="0" step="0.1" name="oral05" class="form-control" value="<?= $notaOral_05 ?>"  required></td>
                        </tr>
                        <tr>
                            <td class="text-left">6. Adequação do Vocabulário Utilizado</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number" max="1" min="0" step="0.1" name="oral06" class="form-control" value="<?= $notaOral_06 ?>"  required></td>
                        </tr>
                        <tr>
                            <td class="text-left">7. Preparação Adequada dos Recursos Técnicos para Apresentação</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><input type="number" max="1" min="0" step="0.1" id="oral07" name="oral07" class="form-control" value="<?= $notaOral_07 ?>"  required></td>
                        </tr>
                        <tr>
                            <th colspan="3" style="background: #ffff99;" class="text-center font">Comentário (Preenchimento Obrigatório)</th>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">
                                <textarea cols="100%" rows="10" minlength="10" name="comentario" required><?= $comentario ?></textarea>
                               
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 col-sm-12 d-flex">&nbsp;</div>
                    <!--============= BOTAO DE SALVAR ============= -->	
                    <div class="col-md-6 col-sm-12 d-flex">
                        <input class="btn btn-block btn-primary" value="Salvar" type="submit" name="btneditar"> 
                    </div>
                </div>

            </div>

        </form>
        <!--============= FIM FORMULARIO ============= -->	



    </div>
</div><!-- comment -->

<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    $escrita01 = filter_input(INPUT_POST, 'escrita01');
    $escrita02 = filter_input(INPUT_POST, 'escrita02');
    $escrita03 = filter_input(INPUT_POST, 'escrita03');
    $escrita04 = filter_input(INPUT_POST, 'escrita04');
    $escrita05 = filter_input(INPUT_POST, 'escrita05');
    $escrita06 = filter_input(INPUT_POST, 'escrita06');
    $escrita07 = filter_input(INPUT_POST, 'escrita07');

    $oral01 = filter_input(INPUT_POST, 'oral01');
    $oral02 = filter_input(INPUT_POST, 'oral02');
    $oral03 = filter_input(INPUT_POST, 'oral03');
    $oral04 = filter_input(INPUT_POST, 'oral04');
    $oral05 = filter_input(INPUT_POST, 'oral05');
    $oral06 = filter_input(INPUT_POST, 'oral06');
    $oral07 = filter_input(INPUT_POST, 'oral07');

    $formatacao01 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao01') : null);
    $formatacao02 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao02') : null);
    $formatacao03 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao03') : null);
    $formatacao04 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao04') : null);
    $formatacao05 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao05') : null);
    $formatacao06 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao06') : null);
    $formatacao07 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao07') : null);
    $formatacao08 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao08') : null);
    $formatacao09 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao09') : null);
    $formatacao10 = ($tipo == "orientador" ? filter_input(INPUT_POST, 'formatacao10') : null);

    $acumula_formatacao = ($tipo == "orientador" ? ($formatacao01 + $formatacao02 + $formatacao03 + $formatacao04 + $formatacao05 + $formatacao06 + $formatacao07 + $formatacao08 + $formatacao09 + $formatacao10) : 0);

    $b->setNotaFormatacao_01($formatacao01);
    $b->setNotaFormatacao_02($formatacao02);
    $b->setNotaFormatacao_03($formatacao03);
    $b->setNotaFormatacao_04($formatacao04);
    $b->setNotaFormatacao_05($formatacao05);
    $b->setNotaFormatacao_06($formatacao06);
    $b->setNotaFormatacao_07($formatacao07);
    $b->setNotaFormatacao_08($formatacao08);
    $b->setNotaFormatacao_09($formatacao09);
    $b->setNotaFormatacao_10($formatacao10);

    $b->setNotaFormatacao($acumula_formatacao);

    $comentarios = filter_input(INPUT_POST, 'comentario');

    $b->setComentario($comentarios);

    $b->setNotaEscrita_01($escrita01);
    $b->setNotaEscrita_02($escrita02);
    $b->setNotaEscrita_03($escrita03);
    $b->setNotaEscrita_04($escrita04);
    $b->setNotaEscrita_05($escrita05);
    $b->setNotaEscrita_06($escrita06);
    $b->setNotaEscrita_07($escrita07);

    $acumula_escrita = ($escrita01 + $escrita02 + $escrita03 + $escrita04 + $escrita05 + $escrita06 + $escrita07);

    $b->setNotaOral_01($oral01);
    $b->setNotaOral_02($oral02);
    $b->setNotaOral_03($oral03);
    $b->setNotaOral_04($oral04);
    $b->setNotaOral_05($oral05);
    $b->setNotaOral_06($oral06);
    $b->setNotaOral_07($oral07);

    $acumula_oral = ($oral01 + $oral02 + $oral03 + $oral04 + $oral05 + $oral06 + $oral07);

    $b->setNotaEscrita($acumula_escrita);
    $b->setNotaOral($acumula_oral);

    $divisor = $tipo == "orientador" ? 3 : 2;
    //$media = ($acumula_escrita + $acumula_formatacao + $acumula_oral) / $divisor;
    $media = ($acumula_escrita * 0.4) + ($acumula_formatacao * 0.1) + ($acumula_oral * 0.3) + ($nota * 0.2);
    $b->setNotaBanca_Final($media);

    if ($tipo == "orientador") {
        if ($b->editarNotasOrientador()) {
            $b->editarNotaFormatacao($vinculo);
            ?>
            <div class="alert alert-success mt-3" role="alert">
                Notas enviadas com sucesso pelo orientador
            </div>
            <?php
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=notas/listar">';
            ?>

            <?php
        }
    } else {
        if ($b->editarNotasProfessor()) {
            ?>
            <div class="alert alert-success mt-3" role="alert">
                Notas enviadas com sucesso 
            </div>
            <?php
            echo '<meta http-equiv="refresh" CONTENT="1;URL=?p=notas/listar">';
            ?>

            <?php
        }
    }
}    