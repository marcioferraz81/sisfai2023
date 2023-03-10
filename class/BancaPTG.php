<?php

include_once 'Conectar.php';

class BancaPTG
{

    private $codBanca;
    private $vinculoPTG;
    private $professor;
    private $tipoBanca;
    private $notaBanca_Final;
    private $notaBanca;
    private $data;
    private $status;
    private $comentario;
    private $conn;

    public function getCodBanca()
    {
        return $this->codBanca;
    }

    public function getVinculoPTG()
    {
        return $this->vinculoPTG;
    }

    public function getProfessor()
    {
        return $this->professor;
    }

    public function getTipoBanca()
    {
        return $this->tipoBanca;
    }

    public function getNotaBanca_Final()
    {
        return $this->notaBanca_Final;
    }

    public function getNotaBanca()
    {
        return $this->notaBanca;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function setCodBanca($codBanca): void
    {
        $this->codBanca = $codBanca;
    }

    public function setVinculoPTG($vinculoPTG): void
    {
        $this->vinculoPTG = $vinculoPTG;
    }

    public function setProfessor($professor): void
    {
        $this->professor = $professor;
    }

    public function setTipoBanca($tipoBanca): void
    {
        $this->tipoBanca = $tipoBanca;
    }

    public function setNotaBanca_Final($notaBanca_Final): void
    {
        $this->notaBanca_Final = $notaBanca_Final;
    }

    public function setNotaBanca($notaBanca): void
    {
        $this->notaBanca = $notaBanca;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    public function salvarPrimeiraEtapa()
    {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancaptg VALUES (NULL,?, ?, ?, 0, 0, ?, 0, null)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoPTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    //vou considerar status 9 para barrar o aluno
    public function barrar()
    {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancaptg VALUES (NULL,?, ?, ?, 0, 0, ?, 9, null)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoPTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            return $executar->execute() == 1 ? "trabalho inapto" : "Erro";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function salvarSegundaEtapa()
    {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO bancaptg VALUES (NULL,?, ?, ?, 0, 0, ?, 1, null)";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoPTG);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->tipoBanca);
            $executar->bindValue(4, date('Y-m-d H:i:s'));

            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editarSegundaEtapa()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE bancaptg SET status = 1 WHERE vinculoPTG = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->vinculoPTG);

            return $executar->execute() == 1 ? "Atualizado com sucesso" : "Erro ao atualizar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarPrimeiraEtapa()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT count(v.id_vinculoPTG) FROM vinculoptg v "
                . "WHERE (v.id_vinculoPTG IN (SELECT b.vinculoPTG FROM bancaptg b)) AND v.id_vinculoPTG = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoPTG);
            return $executar->execute() == 1 ? $executar->fetchColumn() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarSegundaEtapa()
    {
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
                . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
                . "WHERE b.vinculoptg = v.id_vinculoptg AND d.matricula_docente = v.professor "
                . "AND a.ra_aluno = v.aluno AND v.semestre = ? "
                . "AND c.matricula_coordenador = ? GROUP BY a.nome_aluno;";
            /*
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo as titulo, b.status as status "
            . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
            . "WHERE b.vinculoptg = v.id_vinculoptg AND d.matricula_docente = v.professor "
            . "AND a.ra_aluno = v.aluno "
            . "AND c.matricula_coordenador = ? AND b.status = 0";
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

    public function contarMembrosBanca($vinculo)
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.* FROM bancaptg b WHERE b.vinculoptg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $vinculo);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarTerceiraEtapa()
    {
        try {
            $this->con = new Conectar();
            $semestre = date('Y') . (date('m') < 7 ? 1 : 2);
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, a.ra_aluno as 'ra_aluno', v.primeira_nota "
                . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
                . "WHERE b.vinculoptg = v.id_vinculoptg AND d.matricula_docente = v.professor "
                . "AND a.ra_aluno = v.aluno AND v.semestre = ? "
                . "AND b.professor = ? AND (b.status = 0 OR b.status = 1 OR b.status = 2) GROUP BY b.vinculoptg";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $semestre);
            $executar->bindValue(2, $this->professor);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarNotasBancaPorProfessor()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente "
                . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
                . "WHERE b.vinculoptg = v.id_vinculoptg AND d.matricula_docente = v.professor "
                . "AND a.ra_aluno = v.aluno AND b.professor = ? GROUP BY b.vinculoptg";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->professor);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarNotasBancaPorVinculo()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.*, d.nome_docente, d.matricula_docente as mat "
                . "FROM bancaptg b, docente d "
                . "WHERE d.matricula_docente = b.professor AND b.vinculoptg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoPTG);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarTerceiraEtapaVinculo()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.*, a.nome_aluno, d.nome_docente, v.titulo "
                . "FROM bancaptg b "
                . "INNER JOIN vinculoptg v ON b.vinculoptg = v.id_vinculoptg "
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

    public function buscarMembros($vinculo)
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.codBanca, b.professor, d.nome_docente, b.tipoBanca, b.notabanca_final "
                . "FROM bancaptg b "
                . "INNER JOIN docente d ON d.matricula_docente = b.professor "
                . "WHERE b.vinculoptg = ?";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $vinculo);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editarNotasProfessor()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE bancaptg SET comentario = ?, notaBanca = ?, notaBanca_Final = ? WHERE codBanca = ?";
            $executar = $this->con->prepare($sql);
//passar parametros para as interrogações
            $executar->bindValue(1, $this->comentario);
            $executar->bindValue(2, $this->notaBanca);
            $executar->bindValue(3, $this->notaBanca);
            $executar->bindValue(4, $this->codBanca);

            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir()
    {
        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM bancaptg WHERE codBanca = ?";
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

    public function gerarPDF_varios($semestre)
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.nome_aluno, d.nome_docente, v.titulo, "
                . "(SELECT doc.nome_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'coordenador', "
                . "c.nome_curso, b.*, d.matricula_docente as 'matricula', "
                . "(SELECT doc.matricula_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'matr_coord', retornar_nome_dupla(v.dupla_ptg) as dupla "
                . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
                . "WHERE b.professor = d.matricula_docente AND b.vinculoptg = v.id_vinculoptg "
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

    public function gerarPDF()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.nome_aluno, d.nome_docente, v.titulo, "
                . "(SELECT doc.nome_docente FROM docente doc WHERE doc.matricula_docente = c.matricula_coordenador) as 'coordenador', "
                . "c.nome_curso, b.*, d.matricula_docente as 'matricula' "
                . "FROM bancaptg b, vinculoptg v, docente d , curso c, aluno a "
                . "WHERE b.professor = d.matricula_docente AND b.vinculoptg = v.id_vinculoptg "
                . "AND v.aluno = a.ra_aluno AND a.id_curso = c.id_curso "
                . "AND b.vinculoPTG = ? ";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->vinculoPTG);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
