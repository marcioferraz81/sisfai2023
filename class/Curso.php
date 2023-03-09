<?php

include_once 'Conectar.php';

class Curso {

    private $id;
    private $periodo;
    private $nome;
    private $matricula_coord;
    private $con;

    public function getId() {
        return $this->id;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getMatricula_coord() {
        return $this->matricula_coord;
    }

    public function setMatricula_coord($matricula_coord): void {
        $this->matricula_coord = $matricula_coord;
    }

    function consultar() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT c.*, d.nome_docente FROM curso as c, docente as d WHERE c.matricula_coordenador = d.matricula_docente ORDER BY nome_curso";
            $ligacao = $this->con->prepare($sql);
            return $ligacao->execute() == 1 ? $ligacao->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO curso VALUES (?, ?, ?, ?)";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id);
            $executar->bindValue(2, $this->periodo);
            $executar->bindValue(3, $this->nome);
            $executar->bindValue(4, $this->matricula_coord);
            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editar() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE curso SET periodo_curso = ?, nome_curso = ?, matricula_coordenador = ? WHERE id_curso = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->periodo);
            $executar->bindValue(2, $this->nome);
            $executar->bindValue(3, $this->matricula_coord);
            $executar->bindValue(4, $this->id);

            if ($executar->execute() == 1) {
                return true;
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
            $sql = "SELECT * FROM curso WHERE id_curso = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id);

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
            $sql = "DELETE FROM curso WHERE id_curso = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
    
    
    function contarHAE() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT horas, periodo_curso, nome_curso, id_curso FROM curso WHERE matricula_coordenador = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->matricula_coord);

            if ($executar->execute() == 1) {
                return $executar->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
