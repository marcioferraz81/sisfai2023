<?php

include_once 'Conectar.php';

class VinculoTG {

    private $aluno;
    private $professor;
    private $semestre;
    private $dupla;
    private $primeira_nota;

    public function getPrimeira_nota() {
        return $this->primeira_nota;
    }

    public function setPrimeira_nota($primeira_nota): void {
        $this->primeira_nota = $primeira_nota;
    }

    public function getAluno() {
        return $this->aluno;
    }

    public function getProfessor() {
        return $this->professor;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getDupla() {
        return $this->dupla;
    }

    public function setAluno($aluno): void {
        $this->aluno = $aluno;
    }

    public function setProfessor($professor): void {
        $this->professor = $professor;
    }

    public function setSemestre($semestre): void {
        $this->semestre = $semestre;
    }

    public function setDupla($dupla): void {
        $this->dupla = $dupla;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "CALL inserir_vinculoTG(?, ?, ?, ?)";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->professor);
            $executar->bindValue(2, $this->aluno);
            $executar->bindValue(3, $this->semestre);
            $executar->bindValue(4, $this->dupla);

            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar($curso) {
        try {
            $this->con = new Conectar();
            //$sql = "SELECT * FROM listar_vinculotg";
            $sql = "SELECT tg.professor AS professor, tg.aluno AS aluno, tg.semestre AS semestre, 
                tg.dupla_tg AS dupla_tg, d.nome_docente AS nome_docente, a.nome_aluno AS nome_aluno, 
                retornar_nome_dupla(tg.dupla_tg) AS dupla, tg.id_vinculotg as vinculo, tg.primeira_nota as nota
                FROM vinculotg tg, docente d, aluno a 
                WHERE tg.professor = d.matricula_docente AND tg.aluno = a.ra_aluno AND a.id_curso = ? AND tg.semestre = ? 
                ORDER BY a.nome_aluno ASC;";

            $ano = date('Y');
            $semestre = 1;
            $mes = date('m');

            if ($mes >= 11 && $mes <= 12) {
                $semestre = 2;
            } else if ($mes >= 1 && $mes <= 4) {
                $semestre = 2;
                $ano = $ano - 1;
            }

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $curso);
            $executar->bindValue(2, $ano . $semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
    function consultar2($curso, $semestre) {
        try {
            $this->con = new Conectar();
            //$sql = "SELECT * FROM listar_vinculotg";
            $sql = "SELECT tg.professor AS professor, tg.aluno AS aluno, tg.semestre AS semestre, 
                tg.dupla_tg AS dupla_tg, d.nome_docente AS nome_docente, a.nome_aluno AS nome_aluno, 
                retornar_nome_dupla(tg.dupla_tg) AS dupla, tg.id_vinculotg as vinculo, tg.primeira_nota as nota
                FROM vinculotg tg, docente d, aluno a 
                WHERE tg.professor = d.matricula_docente AND tg.aluno = a.ra_aluno AND a.id_curso = ? AND tg.semestre = ? 
                ORDER BY a.nome_aluno ASC;";           

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $curso);
            $executar->bindValue(2, $semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarPorDocente($matricula) {
        try {
            $this->con = new Conectar();
            //$sql = "SELECT * FROM listar_vinculotg";
            $sql = "SELECT tg.professor AS professor, tg.aluno AS aluno, tg.semestre AS semestre, 
                tg.dupla_tg AS dupla_tg, d.nome_docente AS nome_docente, a.nome_aluno AS nome_aluno, 
                retornar_nome_dupla(tg.dupla_tg) AS dupla, tg.primeira_nota, tg.id_vinculoTG 
                FROM vinculotg tg, docente d, aluno a 
                WHERE tg.professor = d.matricula_docente AND tg.aluno = a.ra_aluno AND tg.professor = ? AND tg.semestre = ?;";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $matricula);
            $executar->bindValue(2, date('Y') . (date('m') < 7 ? 1 : 2));

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarAdmin() {
        try {
            $this->con = new Conectar();
            //$sql = "SELECT * FROM listar_vinculotg";
            $sql = "SELECT tg.professor AS professor, tg.aluno AS aluno, tg.semestre AS semestre, 
                tg.dupla_tg AS dupla_tg, d.nome_docente AS nome_docente, a.nome_aluno AS nome_aluno, 
                retornar_nome_dupla(tg.dupla_tg) AS dupla 
                FROM vinculotg tg, docente d, aluno a 
                WHERE tg.professor = d.matricula_docente AND tg.aluno = a.ra_aluno AND tg.semestre = ?;";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarAluno($curso) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM aluno "
                    . "WHERE semestre = ? AND tipo_trabalho = 'tg' AND id_curso = ? "
                    . "ORDER BY nome_aluno";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));
            $executar->bindValue(2, $curso);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarAluno2($curso) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.* FROM aluno a "
                    . "WHERE (a.ra_aluno NOT IN (SELECT v.aluno FROM vinculotg v)) "
                    . "AND (a.ra_aluno NOT IN (SELECT v.dupla_tg FROM vinculotg v)) "
                    . "AND a.semestre = ? AND a.tipo_trabalho = 'tg' AND a.id_curso = ? "
                    . "ORDER BY a.nome_aluno";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));
            $executar->bindValue(2, $curso);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarProfessor() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM docente WHERE qtdHAE>0 ORDER BY nome_docente ASC";
            $executar = $this->con->prepare($sql);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultarPorID() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM listar_vinculotg WHERE aluno = ? AND professor = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->aluno);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM vinculotg WHERE aluno = ? AND professor = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->aluno);
            $executar->bindValue(2, $this->professor);
            $executar->bindValue(3, $this->semestre);

            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarVinculo($semestreAnterior) {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE vinculotg SET professor = ?, semestre = ? WHERE aluno = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->professor, PDO::PARAM_INT);
            $executar->bindValue(2, $this->semestre, PDO::PARAM_INT);
            $executar->bindValue(3, $this->aluno, PDO::PARAM_INT);
            $executar->bindValue(4, $semestreAnterior, PDO::PARAM_INT);

            if ($executar->execute() == 1) {
                return "Editado com sucesso";
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluirdupla() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE vinculotg SET dupla_tg = ? WHERE aluno = ? AND professor = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, NULL);
            $executar->bindValue(2, $this->aluno);
            $executar->bindValue(3, $this->professor);
            $executar->bindValue(4, $this->semestre);

            if ($executar->execute() == 1) {
                return "Editado com sucesso";
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function adicionardupla() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE vinculotg SET dupla_tg = ? WHERE aluno = ? AND professor = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->dupla);
            $executar->bindValue(2, $this->aluno);
            $executar->bindValue(3, $this->professor);
            $executar->bindValue(4, $this->semestre);

            if ($executar->execute() == 1) {
                return "Editado com sucesso";
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function contar($curso) {
        try {
            $this->con = new Conectar();
            //$sql = "SELECT count(*) FROM listar_vinculotg";           

            $sql = "SELECT count(*) 
                FROM vinculotg tg, docente d, aluno a 
                WHERE tg.professor = d.matricula_docente AND tg.aluno = a.ra_aluno AND a.id_curso = ? AND tg.semestre = ?;";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $curso);
            $executar->bindValue(2, date('Y') . (date('m') < 7 ? 1 : 2));

            if ($executar->execute() == 1) {
                return $executar->fetchColumn();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function pesquisarPorRA() {
        try {
            $this->con = new Conectar();
            $ano = date('Y');
            $semestre = date('m') < 7 ? 1 : 2;
            $sql = "SELECT tg.titulo, tg.link_video, tg.link_drive, tg.primeira_nota, "
                    . "tg.id_vinculoTG FROM vinculotg as tg "
                    . "WHERE tg.semestre = ? AND tg.aluno = ? OR tg.dupla_tg = ?";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $ano . $semestre);
            $executar->bindValue(2, $this->aluno);
            $executar->bindValue(3, $this->aluno);

            return ($executar->execute() == 1 ? $executar->fetchAll() : false);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarNota() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE vinculotg SET primeira_nota = ? WHERE aluno = ? OR dupla_tg = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->primeira_nota, PDO::PARAM_STR);
            $executar->bindValue(2, $this->aluno, PDO::PARAM_INT);
            $executar->bindValue(3, $this->aluno, PDO::PARAM_INT);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function enviarTrabalho($titulo, $link_video, $link_drive, $id_vinculo) {
        try {
            $this->con = new Conectar();
            /*
              $sql = "UPDATE vinculotg SET titulo = ?, link_video = ?, link_drive = ? "
              . "WHERE (aluno = ? OR dupla_tg = ?) AND semestre = ?;";
             * 
             */
            $sql = "UPDATE vinculotg SET titulo = ?, link_video = ?, link_drive = ? "
                    . "WHERE id_vinculoTG = ?;";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, trim($titulo), PDO::PARAM_STR);
            $executar->bindValue(2, trim($link_video), PDO::PARAM_STR);
            $executar->bindValue(3, trim($link_drive), PDO::PARAM_STR);
            $executar->bindValue(4, trim($id_vinculo), PDO::PARAM_INT);
            /*
              $executar->bindValue(4, $this->aluno, PDO::PARAM_INT);
              $executar->bindValue(5, $this->aluno, PDO::PARAM_INT);
              $executar->bindValue(6, trim($this->semestre), PDO::PARAM_INT);
             * 
             */

            return ($executar->execute() == 1) ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
