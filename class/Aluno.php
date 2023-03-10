<?php

include_once 'Conectar.php';

class Aluno
{

    private $ra;
    private $status;
    private $email;
    private $fone;
    private $nome;
    private $tipo;
    private $semestre;
    private $senha;
    private $id_curso;
    private $tipo_trabalho;
    private $con;

    public function getRa()
    {
        return $this->ra;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFone()
    {
        return $this->fone;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getSemestre()
    {
        return $this->semestre;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getId_curso()
    {
        return $this->id_curso;
    }

    public function setRa($ra)
    {
        $this->ra = $ra;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function setId_curso($id_curso)
    {
        $this->id_curso = $id_curso;
    }

    public function getTipo_trabalho()
    {
        return $this->tipo_trabalho;
    }

    public function setTipo_trabalho($tipo_trabalho): void
    {
        $this->tipo_trabalho = $tipo_trabalho;
    }

    public function salvar()
    {
        try {
            /*
             * ra, statusa, email, fone, nome, tipoUsuario, semestre, senha, curso
             */

            $this->con = new Conectar();
            $sql = "CALL inserir_aluno(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->ra);
            $executar->bindValue(2, 1);
            $executar->bindValue(3, $this->email);
            $executar->bindValue(4, $this->fone);
            $executar->bindValue(5, $this->nome);
            $executar->bindValue(6, 0);
            $executar->bindValue(7, $this->semestre);
            $executar->bindValue(8, sha1($this->ra));
            $executar->bindValue(9, $this->id_curso);
            $executar->bindValue(10, $this->tipo_trabalho);

            return $executar->execute() == 1 ? "Cadastrado com sucesso" : "Erro ao cadastrar";
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function consultar()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c WHERE a.id_curso = c.id_curso ORDER BY a.nome_aluno";
            $ligacao = $this->con->prepare($sql);
            return $ligacao->execute() == 1 ? $ligacao->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function consultarPorID()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c WHERE a.ra_aluno = ? AND a.id_curso = c.id_curso";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->ra);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function consultarPorCurso()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c WHERE a.id_curso = ? AND a.id_curso = c.id_curso";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function consultarPtgPorSemestre()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c "
                . "WHERE a.id_curso = ? "
                . "AND a.id_curso = c.id_curso "
                . "AND a.semestre = ?  "
                . "AND a.tipo_trabalho = 'ptg'";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);
            $executar->bindValue(2, $this->semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisar()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c "
                . "WHERE a.id_curso = ? AND a.semestre = ? AND a.tipo_trabalho = ? "
                . "AND a.id_curso = c.id_curso ORDER BY a.nome_aluno";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);
            $executar->bindValue(2, $this->semestre);
            $executar->bindValue(3, $this->tipo_trabalho);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarIndefinidos()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c "
                . "WHERE a.id_curso = ? AND a.semestre = ? AND "
                . "(a.ra_aluno NOT IN (SELECT ra_aluno FROM aluno WHERE a.tipo_trabalho = 'tg' OR a.tipo_trabalho = 'ptg')) "
                . "AND a.id_curso = c.id_curso ORDER BY a.nome_aluno";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);
            $executar->bindValue(2, $this->semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarPTG()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT t.titulo, t.link_video, t.link_drive, t.primeira_nota "
                . "FROM vinculoptg t "
                . "INNER JOIN aluno a ON (t.aluno = a.ra_aluno OR t.dupla_ptg = a.ra_aluno) "
                . "WHERE t.semestre = ? AND a.ra_aluno = ?;";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));
            $executar->bindValue(2, $this->ra);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarTG()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT t.titulo, t.link_video, t.link_drive, t.primeira_nota
                    FROM vinculotg t
                    INNER JOIN aluno a ON t.aluno = a.ra_aluno OR t.dupla_tg = a.ra_aluno
                    WHERE t.semestre = ? AND (t.aluno = ? OR dupla_tg = ?)";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));
            $executar->bindValue(2, $this->ra);
            $executar->bindValue(3, $this->ra);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarTrabalho()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT t.titulo, t.link_video, t.link_drive "
                . "FROM vinculotg as t, aluno a "
                . "WHERE t.semestre = ? AND a.ra_aluno = ? AND t.aluno = a.ra_aluno OR t.dupla_tg = a.ra_aluno;";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, date('Y') . (date('m') < 7 ? 1 : 2));
            $executar->bindValue(2, $this->ra);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarSemVinculo()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT a.*, c.* FROM aluno as a, curso as c "
                . "WHERE a.id_curso = ? AND a.semestre = ? "
                . "AND (a.ra_aluno NOT IN (SELECT aluno FROM vinculoptg)) "
                . "AND (ra_aluno NOT IN (SELECT dupla_ptg FROM vinculoptg)) "
                . "AND (a.ra_aluno NOT IN (SELECT aluno FROM vinculotg)) "
                . "AND (ra_aluno NOT IN (SELECT dupla_tg FROM vinculotg)) "
                . "AND a.id_curso = c.id_curso ORDER BY a.tipo_trabalho, a.nome_aluno";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);
            $executar->bindValue(2, $this->semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarSemVinculoPorRA()
    {
        try {
            $this->con = new Conectar();
            $ano = date('Y');
            $semestre = date('m') < 7 ? 1 : 2;
            $sql = "SELECT a.ra_aluno FROM aluno as a "
                . "WHERE a.semestre = ? AND a.ra_aluno = ? "
                . "AND (a.ra_aluno NOT IN (SELECT aluno FROM vinculoptg)) "
                . "AND (a.ra_aluno NOT IN (SELECT dupla_ptg FROM vinculoptg)) "
                . "AND (a.ra_aluno NOT IN (SELECT aluno FROM vinculotg)) "
                . "AND (a.ra_aluno NOT IN (SELECT dupla_tg FROM vinculotg));";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $ano . $semestre);
            $executar->bindValue(2, $this->ra);

            return ($executar->execute() == 1 ? $executar->fetchAll() : false);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editar()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE aluno SET id_curso = ?, semestre = ?, nome_aluno = ?, status_aluno = ?, tipo_trabalho = ? WHERE ra_aluno = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->id_curso, PDO::PARAM_INT);
            $executar->bindValue(2, $this->semestre, PDO::PARAM_INT);
            $executar->bindValue(3, $this->nome, PDO::PARAM_STR);
            $executar->bindValue(4, '1');
            $executar->bindValue(5, $this->tipo_trabalho, PDO::PARAM_STR);
            $executar->bindValue(6, $this->ra, PDO::PARAM_INT);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editarAluno()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE aluno SET email_aluno = ?, fone_aluno = ? WHERE ra_aluno = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->email, PDO::PARAM_STR);
            $executar->bindValue(2, $this->fone, PDO::PARAM_STR);
            $executar->bindValue(3, $this->ra, PDO::PARAM_INT);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function enviarTrabalho($titulo, $link_video, $link_drive, $table)
    {
        try {
            $this->con = new Conectar();
            //$sql = "CALL enviarTrabalho(?,?,?,?,?);";
            $campo = $table == 'vinculotg' ? 'dupla_tg' : 'dupla_ptg';
            //$campo = $table == 'vinculotg' ? 'id_vinculoTG' : 'id_vinculoPTG';
            //vamos trabalhar com o id do vinculo (tenho que dar um jeito aqui)
            //anotação de 03/02/2023
            /*
             * $sql = "UPDATE " . $table . " SET titulo = ?, link_video = ?, link_drive = ? "
            . "WHERE " . $campo . " = ?;";
             */

            $sql = "UPDATE " . $table . " SET titulo = ?, link_video = ?, link_drive = ? "
                . "WHERE (aluno = ? OR " . $campo . " = ?) AND semestre = ?;";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(4, trim($this->ra), PDO::PARAM_INT);
            $executar->bindValue(5, trim($this->ra), PDO::PARAM_INT);
            $executar->bindValue(6, trim($this->semestre), PDO::PARAM_INT);
            $executar->bindValue(1, trim($titulo), PDO::PARAM_STR);
            $executar->bindValue(2, trim($link_video), PDO::PARAM_STR);
            $executar->bindValue(3, trim($link_drive), PDO::PARAM_STR);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir()
    {
        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM aluno WHERE ra_aluno = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->ra);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function contarPorCurso()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT count(ra_aluno) FROM aluno WHERE id_curso = ? AND semestre = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id_curso);
            $executar->bindValue(2, $this->semestre);

            if ($executar->execute() == 1) {
                return $executar->fetchColumn();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarAvaliacaoBancaPTG()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.tipoBanca as banca, d.nome_docente as professor, b.notaBanca as nota, b.comentario as comentario, v.primeira_nota as nota_orientador, v.id_vinculoPTG as vinculo "
                . "FROM bancaptg b, docente d, vinculoptg v "
                . "WHERE d.matricula_docente = b.professor "
                . "AND v.id_vinculoPTG = b.vinculoPTG "
                . "AND v.aluno = ? OR v.dupla_ptg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->ra);
            $executar->bindValue(2, $this->ra);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisarAvaliacaoBancaTG()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT b.tipoBanca as banca, d.nome_docente as professor, b.notaBanca_Final as nota, b.comentario as comentario, v.primeira_nota as nota_orientador, v.id_vinculoTG as vinculo "
                . "FROM bancatg b, docente d, vinculotg v "
                . "WHERE d.matricula_docente = b.professor "
                . "AND v.id_vinculoTG = b.vinculoTG "
                . "AND v.aluno = ? OR v.dupla_tg = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->ra);
            $executar->bindValue(2, $this->ra);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
