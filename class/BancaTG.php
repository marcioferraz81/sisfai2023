<?php

include_once 'Conectar.php';

class BancaTG {

    private $codBanca;
    private $vinculoTG;
    private $professor;
    private $tipoBanca;
    private $notaBanca_Final;
    private $data;
    private $status;
    private $comentario;
    private $notaEscrita_01;
    private $notaEscrita_02;
    private $notaEscrita_03;
    private $notaEscrita_04;
    private $notaEscrita_05;
    private $notaEscrita_06;
    private $notaEscrita_07;
    private $notaOral_01;
    private $notaOral_02;
    private $notaOral_03;
    private $notaOral_04;
    private $notaOral_05;
    private $notaOral_06;
    private $notaOral_07;
    private $notaFormatacao_01;
    private $notaFormatacao_02;
    private $notaFormatacao_03;
    private $notaFormatacao_04;
    private $notaFormatacao_05;
    private $notaFormatacao_06;
    private $notaFormatacao_07;
    private $notaFormatacao_08;
    private $notaFormatacao_09;
    private $notaFormatacao_10;
    private $notaFormatacao;
    private $notaEscrita;
    private $notaOral;
    private $conn;

    public function getCodBanca() {
        return $this->codBanca;
    }

    public function getVinculoTG() {
        return $this->vinculoTG;
    }

    public function getProfessor() {
        return $this->professor;
    }

    public function getTipoBanca() {
        return $this->tipoBanca;
    }

    public function getNotaBanca_Final() {
        return $this->notaBanca_Final;
    }

    public function getData() {
        return $this->data;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function getNotaEscrita_01() {
        return $this->notaEscrita_01;
    }

    public function getNotaEscrita_02() {
        return $this->notaEscrita_02;
    }

    public function getNotaEscrita_03() {
        return $this->notaEscrita_03;
    }

    public function getNotaEscrita_04() {
        return $this->notaEscrita_04;
    }

    public function getNotaEscrita_05() {
        return $this->notaEscrita_05;
    }

    public function getNotaEscrita_06() {
        return $this->notaEscrita_06;
    }

    public function getNotaEscrita_07() {
        return $this->notaEscrita_07;
    }

    public function getNotaOral_01() {
        return $this->notaOral_01;
    }

    public function getNotaOral_02() {
        return $this->notaOral_02;
    }

    public function getNotaOral_03() {
        return $this->notaOral_03;
    }

    public function getNotaOral_04() {
        return $this->notaOral_04;
    }

    public function getNotaOral_05() {
        return $this->notaOral_05;
    }

    public function getNotaOral_06() {
        return $this->notaOral_06;
    }

    public function getNotaOral_07() {
        return $this->notaOral_07;
    }

    public function getNotaFormatacao_01() {
        return $this->notaFormatacao_01;
    }

    public function getNotaFormatacao_02() {
        return $this->notaFormatacao_02;
    }

    public function getNotaFormatacao_03() {
        return $this->notaFormatacao_03;
    }

    public function getNotaFormatacao_04() {
        return $this->notaFormatacao_04;
    }

    public function getNotaFormatacao_05() {
        return $this->notaFormatacao_05;
    }

    public function getNotaFormatacao_06() {
        return $this->notaFormatacao_06;
    }

    public function getNotaFormatacao_07() {
        return $this->notaFormatacao_07;
    }

    public function getNotaFormatacao_08() {
        return $this->notaFormatacao_08;
    }

    public function getNotaFormatacao_09() {
        return $this->notaFormatacao_09;
    }

    public function getNotaFormatacao_10() {
        return $this->notaFormatacao_10;
    }

    public function getNotaFormatacao() {
        return $this->notaFormatacao;
    }

    public function getNotaEscrita() {
        return $this->notaEscrita;
    }

    public function getNotaOral() {
        return $this->notaOral;
    }

    public function setCodBanca($codBanca): void {
        $this->codBanca = $codBanca;
    }

    public function setVinculoTG($vinculoTG): void {
        $this->vinculoTG = $vinculoTG;
    }

    public function setProfessor($professor): void {
        $this->professor = $professor;
    }

    public function setTipoBanca($tipoBanca): void {
        $this->tipoBanca = $tipoBanca;
    }

    public function setNotaBanca_Final($notaBanca_Final): void {
        $this->notaBanca_Final = $notaBanca_Final;
    }

    public function setData($data): void {
        $this->data = $data;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setComentario($comentario): void {
        $this->comentario = $comentario;
    }

    public function setNotaEscrita_01($notaEscrita_01): void {
        $this->notaEscrita_01 = $notaEscrita_01;
    }

    public function setNotaEscrita_02($notaEscrita_02): void {
        $this->notaEscrita_02 = $notaEscrita_02;
    }

    public function setNotaEscrita_03($notaEscrita_03): void {
        $this->notaEscrita_03 = $notaEscrita_03;
    }

    public function setNotaEscrita_04($notaEscrita_04): void {
        $this->notaEscrita_04 = $notaEscrita_04;
    }

    public function setNotaEscrita_05($notaEscrita_05): void {
        $this->notaEscrita_05 = $notaEscrita_05;
    }

    public function setNotaEscrita_06($notaEscrita_06): void {
        $this->notaEscrita_06 = $notaEscrita_06;
    }

    public function setNotaEscrita_07($notaEscrita_07): void {
        $this->notaEscrita_07 = $notaEscrita_07;
    }

    public function setNotaOral_01($notaOral_01): void {
        $this->notaOral_01 = $notaOral_01;
    }

    public function setNotaOral_02($notaOral_02): void {
        $this->notaOral_02 = $notaOral_02;
    }

    public function setNotaOral_03($notaOral_03): void {
        $this->notaOral_03 = $notaOral_03;
    }

    public function setNotaOral_04($notaOral_04): void {
        $this->notaOral_04 = $notaOral_04;
    }

    public function setNotaOral_05($notaOral_05): void {
        $this->notaOral_05 = $notaOral_05;
    }

    public function setNotaOral_06($notaOral_06): void {
        $this->notaOral_06 = $notaOral_06;
    }

    public function setNotaOral_07($notaOral_07): void {
        $this->notaOral_07 = $notaOral_07;
    }

    public function setNotaFormatacao_01($notaFormatacao_01): void {
        $this->notaFormatacao_01 = $notaFormatacao_01;
    }

    public function setNotaFormatacao_02($notaFormatacao_02): void {
        $this->notaFormatacao_02 = $notaFormatacao_02;
    }

    public function setNotaFormatacao_03($notaFormatacao_03): void {
        $this->notaFormatacao_03 = $notaFormatacao_03;
    }

    public function setNotaFormatacao_04($notaFormatacao_04): void {
        $this->notaFormatacao_04 = $notaFormatacao_04;
    }

    public function setNotaFormatacao_05($notaFormatacao_05): void {
        $this->notaFormatacao_05 = $notaFormatacao_05;
    }

    public function setNotaFormatacao_06($notaFormatacao_06): void {
        $this->notaFormatacao_06 = $notaFormatacao_06;
    }

    public function setNotaFormatacao_07($notaFormatacao_07): void {
        $this->notaFormatacao_07 = $notaFormatacao_07;
    }

    public function setNotaFormatacao_08($notaFormatacao_08): void {
        $this->notaFormatacao_08 = $notaFormatacao_08;
    }

    public function setNotaFormatacao_09($notaFormatacao_09): void {
        $this->notaFormatacao_09 = $notaFormatacao_09;
    }

    public function setNotaFormatacao_10($notaFormatacao_10): void {
        $this->notaFormatacao_10 = $notaFormatacao_10;
    }

    public function setNotaFormatacao($notaFormatacao): void {
        $this->notaFormatacao = $notaFormatacao;
    }

    public function setNotaEscrita($notaEscrita): void {
        $this->notaEscrita = $notaEscrita;
    }

    public function setNotaOral($notaOral): void {
        $this->notaOral = $notaOral;
    }

    function salvarPrimeiraEtapa() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancatg (vinculoTG, professor, tipoBanca, data, status) VALUES (?,?,?,?,0)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            //echo $this->vinculoTG;
            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function salvarSegundaEtapa() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancatg (vinculoTG, professor, tipoBanca, data, status) VALUES (?,?,?,?,1)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarSegundaEtapa() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE bancatg SET status = 1 WHERE vinculoTG = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoTG);

            return $executar->execute() == 1 ? "Atualizado com sucesso" : "Erro ao atualizar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function pesquisarPrimeiraEtapa() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT count(v.id_vinculoTG) FROM vinculotg v "
                    . "WHERE (v.id_vinculoTG IN (SELECT b.vinculoTG FROM bancatg b)) AND v.id_vinculoTG = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoTG);
            return $executar->execute() == 1 ? $executar->fetchColumn() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function pesquisarSegundaEtapa() {
        try {
            $this->con = new Conectar();
            /*
              $sql = "SELECT b.*, a.nome_aluno, d.nome_docente FROM bancaptg b "
              . "INNER JOIN $sql = "SELECT b.*, a.nome_aluno, d.nome_docente FROM bancaptg b "
              . "INNER JOIN vinculoptg v ON b.vinculoptg = v.id_vinculoptg "
              . "INNER JOIN docente d ON d.matricula_docente = v.professor "
              . "INNER JOIN curso c ON c.matricula_coordenador = d.matricula_docente "
              . "INNER JOIN  aluno a ON a.ra_aluno = v.aluno "
              . "WHERE c.matricula_coordenador = ? AND b.status = 0"; ON b.vinculoptg = v.id_vinculoptg "
              . "INNER JOIN docente d ON d.matricula_docente = v.professor "
              . "INNER JOIN curso c ON c.matricula_coordenador = d.matricula_docente "
              . "INNER JOIN  aluno a ON a.ra_aluno = v.aluno "
              . "WHERE c.matricula_coordenador = ? AND b.status = 0";
             * 
             */
            $semestre = date('Y') . (date('m') < 7 ? 1 : 2);
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo as titulo, b.status as status "
                    . "FROM bancatg b, vinculotg v, docente d , curso c, aluno a "
                    . "WHERE b.vinculotg = v.id_vinculotg AND d.matricula_docente = v.professor "
                    . "AND a.ra_aluno = v.aluno AND v.semestre = ? "
                    . "AND c.matricula_coordenador = ? GROUP BY a.nome_aluno;";
            /*
              $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo as titulo, b.status as status "
              . "FROM bancatg b "
              . "INNER JOIN vinculotg v ON b.vinculotg = v.id_vinculotg "
              . "INNER JOIN docente d ON d.matricula_docente = v.professor "
              . "INNER JOIN aluno a ON a.ra_aluno = v.aluno "
              . "WHERE c.matricula_coordenador = ?";
             * 
             */
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $semestre);
            $executar->bindValue(2, $this->professor);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function contarMembrosBanca($vinculo) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.* FROM bancatg b WHERE b.vinculotg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $vinculo);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    /*
      function pesquisarTerceiraEtapa() {
      try {
      $this->con = new Conectar();
      $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, a.ra_aluno "
      . "FROM bancatg b, vinculotg v, docente d , curso c, aluno a "
      . "WHERE b.vinculotg = v.id_vinculotg AND d.matricula_docente = v.professor "
      . "AND a.ra_aluno = v.aluno "
      . "AND b.professor = ? AND b.status = 1 OR b.status = 2 GROUP BY b.vinculoTG";
      $executar = $this->con->prepare($sql);
      $executar->bindValue(1, $this->professor);
      return $executar->execute() == 1 ? $executar->fetchAll() : false;
      } catch (PDOException $exc) {
      echo $exc->getMessage();
      }
      } */

    function pesquisarTerceiraEtapa() {
        try {
            $this->con = new Conectar();
            $semestre = date('Y') . (date('m') < 7 ? 1 : 2);
            $sql = "SELECT b.codBanca, b.vinculoTG, b.tipoBanca, a.nome_aluno, d.nome_docente, a.ra_aluno as 'ra_aluno', v.primeira_nota "
                    . "FROM bancatg b "
                    . "INNER JOIN vinculotg v ON b.vinculoTG = v.id_vinculotg "
                    . "INNER JOIN docente d ON d.matricula_docente = v.professor "
                    . "INNER JOIN aluno a ON a.ra_aluno = v.aluno "
                    . "WHERE v.semestre = ? AND b.professor = ? AND (b.status = 0 OR b.status = 1 OR b.status = 2) GROUP BY b.vinculoTG";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $semestre);
            $executar->bindValue(2, $this->professor);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    /*
      function pesquisarTerceiraEtapaVinculo() {
      try {
      $this->con = new Conectar();
      $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo "
      . "FROM bancatg b, vinculotg v, docente d , curso c, aluno a "
      . "WHERE b.vinculotg = v.id_vinculotg AND d.matricula_docente = v.professor "
      . "AND a.ra_aluno = v.aluno "
      . "AND b.codBanca = ? AND b.status = 1 GROUP BY b.professor";
      $executar = $this->con->prepare($sql);
      $executar->bindValue(1, $this->codBanca);
      return $executar->execute() == 1 ? $executar->fetchAll() : false;
      } catch (PDOException $exc) {
      echo $exc->getMessage();
      }
      } */

    function pesquisarTerceiraEtapaVinculo() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo "
                    . "FROM bancatg b "
                    . "INNER JOIN vinculotg v ON b.vinculotg = v.id_vinculotg "
                    . "INNER JOIN docente d ON d.matricula_docente = v.professor "
                    . "INNER JOIN aluno a ON a.ra_aluno = v.aluno "
                    . "WHERE b.codBanca = ? GROUP BY b.professor";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->codBanca);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarNotasProfessor() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE bancatg SET comentario = ?, notaEscrita_01 = ?, "
                    . "notaEscrita_02 = ?, notaEscrita_03 = ?, notaEscrita_04 = ?, "
                    . "notaEscrita_05 = ?,   notaEscrita_06 = ?, notaEscrita_07 = ?, "
                    . "notaOral_01 = ?, notaOral_02 = ?, notaOral_03 = ?, "
                    . "notaOral_04 = ?, notaOral_05 = ?, notaOral_06 = ?, "
                    . "notaOral_07 = ?, notaEscrita = ?, notaOral = ?, "
                    . "notaBanca_Final = ?, status = 2 WHERE codBanca = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->comentario);
            $executar->bindValue(2, $this->notaEscrita_01);
            $executar->bindValue(3, $this->notaEscrita_02);
            $executar->bindValue(4, $this->notaEscrita_03);
            $executar->bindValue(5, $this->notaEscrita_04);
            $executar->bindValue(6, $this->notaEscrita_05);
            $executar->bindValue(7, $this->notaEscrita_06);
            $executar->bindValue(8, $this->notaEscrita_07);
            $executar->bindValue(9, $this->notaOral_01);
            $executar->bindValue(10, $this->notaOral_02);
            $executar->bindValue(11, $this->notaOral_03);
            $executar->bindValue(12, $this->notaOral_04);
            $executar->bindValue(13, $this->notaOral_05);
            $executar->bindValue(14, $this->notaOral_06);
            $executar->bindValue(15, $this->notaOral_07);
            $executar->bindValue(16, $this->notaEscrita);
            $executar->bindValue(17, $this->notaOral);
            $executar->bindValue(18, $this->notaBanca_Final);
            $executar->bindValue(19, $this->codBanca);

            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarNotasOrientador() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE bancatg SET comentario = ?, notaEscrita_01 = ?, "
                    . "notaEscrita_02 = ?, notaEscrita_03 = ?, notaEscrita_04 = ?, "
                    . "notaEscrita_05 = ?,   notaEscrita_06 = ?, notaEscrita_07 = ?, "
                    . "notaOral_01 = ?, notaOral_02 = ?, notaOral_03 = ?, "
                    . "notaOral_04 = ?, notaOral_05 = ?, notaOral_06 = ?, "
                    . "notaOral_07 = ?, notaEscrita = ?, notaOral = ?, "
                    . "notaFormatacao_01 = ?, notaFormatacao_02 = ?, notaFormatacao_03 = ?, "
                    . "notaFormatacao_04 = ?, notaFormatacao_05 = ?, notaFormatacao_06 = ?, "
                    . "notaFormatacao_07 = ?, notaFormatacao_08 = ?, notaFormatacao_09 = ?, "
                    . "notaFormatacao_10 = ?, notaFormatacao= ?, notaBanca_Final = ?, status=2 WHERE codBanca = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->comentario);
            $executar->bindValue(2, $this->notaEscrita_01);
            $executar->bindValue(3, $this->notaEscrita_02);
            $executar->bindValue(4, $this->notaEscrita_03);
            $executar->bindValue(5, $this->notaEscrita_04);
            $executar->bindValue(6, $this->notaEscrita_05);
            $executar->bindValue(7, $this->notaEscrita_06);
            $executar->bindValue(8, $this->notaEscrita_07);
            $executar->bindValue(9, $this->notaOral_01);
            $executar->bindValue(10, $this->notaOral_02);
            $executar->bindValue(11, $this->notaOral_03);
            $executar->bindValue(12, $this->notaOral_04);
            $executar->bindValue(13, $this->notaOral_05);
            $executar->bindValue(14, $this->notaOral_06);
            $executar->bindValue(15, $this->notaOral_07);
            $executar->bindValue(16, $this->notaEscrita);
            $executar->bindValue(17, $this->notaOral);
            $executar->bindValue(18, $this->notaFormatacao_01);
            $executar->bindValue(19, $this->notaFormatacao_02);
            $executar->bindValue(20, $this->notaFormatacao_03);
            $executar->bindValue(21, $this->notaFormatacao_04);
            $executar->bindValue(22, $this->notaFormatacao_05);
            $executar->bindValue(23, $this->notaFormatacao_06);
            $executar->bindValue(24, $this->notaFormatacao_07);
            $executar->bindValue(25, $this->notaFormatacao_08);
            $executar->bindValue(26, $this->notaFormatacao_09);
            $executar->bindValue(27, $this->notaFormatacao_10);
            $executar->bindValue(28, number_format($this->notaFormatacao, 2));
            $executar->bindValue(29, $this->notaBanca_Final);
            $executar->bindValue(30, $this->codBanca);

            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarNotaFormatacao($vinculo) {
        try {
            $this->con = new Conectar();

            $sql = "UPDATE bancatg SET notaFormatacao= ? WHERE vinculoTG = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->notaFormatacao);
            $executar->bindValue(2, $vinculo);

            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function buscarNotaFormatacaoOrientador() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.notaFormataco "
                    . "FROM bancatg b "
                    . "WHERE b.tipoBanca = 'orientador' AND b.vinculoTG = ? ";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoTG);
            return $executar->execute() == 1 ? $executar->fetchAll() : 0;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function listarGerarPDF() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo "
                    . "FROM bancatg b "
                    . "INNER JOIN vinculotg v ON b.vinculotg = v.id_vinculotg "
                    . "INNER JOIN docente d ON d.matricula_docente = v.professor "
                    . "INNER JOIN aluno a ON a.ra_aluno = v.aluno "
                    . "WHERE b.professor = ? AND b.status = 2";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->professor);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function gerarPDF() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.nome_aluno, d.nome_docente, v.titulo, "
                    . "(SELECT doc.nome_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'coordenador', "
                    . "c.nome_curso, b.*, d.matricula_docente as 'matricula' "
                    . "FROM bancatg b, vinculotg v, docente d , curso c, aluno a "
                    . "WHERE b.professor = d.matricula_docente AND b.vinculotg = v.id_vinculotg "
                    . "AND v.aluno = a.ra_aluno AND a.id_curso = c.id_curso "
                    . "AND b.vinculoTG = ? ";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoTG);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function gerarPDF_varios($semestre) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.nome_aluno, d.nome_docente, v.titulo, "
                    . "(SELECT doc.nome_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'coordenador', "
                    . "c.nome_curso, b.*, d.matricula_docente as 'matricula', "
                    . "(SELECT doc.matricula_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'matr_coord', retornar_nome_dupla(v.dupla_tg) as dupla "
                    . "FROM bancatg b, vinculotg v, docente d , curso c, aluno a "
                    . "WHERE b.professor = d.matricula_docente AND b.vinculotg = v.id_vinculotg "
                    . "AND v.aluno = a.ra_aluno AND a.id_curso = c.id_curso "
                    . "AND b.professor = ? AND v.semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->professor);
            $executar->bindValue(2, $semestre);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    //vou considerar status 9 para barrar o aluno
    function barrar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancatg (vinculoTG, professor, tipoBanca, data, status) VALUES (?,?,?,?,9)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            return $executar->execute() == 1 ? "trabalho inapto" : "Erro";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function pesquisarNotasBancaPorVinculo() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.tipoBanca, b.notaBanca_Final, b.comentario, d.nome_docente as docente, b.notaEscrita, b.notaOral, b.notaFormatacao, d.matricula_docente as mat "
                    . "FROM bancatg b "
                    . "INNER JOIN docente d ON d.matricula_docente = b.professor "
                    . "WHERE b.vinculotg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoTG);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function buscarMembros($vinculo) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.codBanca, b.professor, d.nome_docente, b.tipoBanca, b.notabanca_final "
                    . "FROM bancatg b "
                    . "INNER JOIN docente d ON d.matricula_docente = b.professor "
                    . "WHERE b.vinculotg = ?";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $vinculo);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM bancatg WHERE codBanca = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->codBanca);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
