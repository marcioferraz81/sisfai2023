
<h3><!--como fizemos em consultar-->
    Gerar ATAs
</h3>

<div class="card shadow"><!-- acrescentei um card com sombra aqui tbm -->
    <form method="post" name="formsalvar" id="formSalvar" class="m-3">
        <!-- m-3 determinei todas as bordas, não mudei o form-->

        <div class="form-group row">

            <div class="col-sm-3">
                <select class="form-control" aria-label="Default select example" name="selano" id="selano" required>
                    <option disabled selected>Escolha o ano</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>    
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control" aria-label="Default select example" name="selsemestre" id="selsemestre" required>
                    <option disabled selected>Escolha o semestre</option>
                    <option value="1">1º semestre</option>
                    <option value="2">2º semestre</option>  
                </select>
            </div>

            <div class="col-sm-4">            
                <input type="submit" 
                       class="btn btn-primary" name="btngerartg" value="ATAs TG">               
                <input type="submit" 
                       class="btn btn-success" name="btngerarptg" value="ATAs PTG">               
            </div>
        </div>
    </form>
</div>
<br>
<br>
<br>
<h4 style="color: red; text-align: center;" class="col-sm-12 col-md-12">
    <?php
    if (filter_input(INPUT_POST, 'btngerartg')) {
        $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
        $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
        ?>
        <a style="color: red; " class="nav-link" onclick="printPage('?p=notas/atasTG&semestre=<?= $ano . $semestre ?>');" href="#">
            Clique aqui para imprimir Atas TG de <?= $ano ?> / <?= $semestre ?>º semestre
        </a>
        <?php
    }
    if (filter_input(INPUT_POST, 'btngerarptg')) {
        $ano = filter_input(INPUT_POST, 'selano', FILTER_SANITIZE_NUMBER_INT);
        $semestre = filter_input(INPUT_POST, 'selsemestre', FILTER_SANITIZE_NUMBER_INT);
        ?>
        <a style="color: red; " class="nav-link" onclick="printPage('?p=notas/atasPTG&semestre=<?= $ano . $semestre ?>');" href="#">
            Clique aqui para imprimir Atas PTG  de <?= $ano ?> / <?= $semestre ?>º semestre
        </a>
        <?php
    }
    ?>
</h4>