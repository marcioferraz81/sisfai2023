<?php

include_once 'Conectar.php';

class Usuario {

    private $matricula;
    private $senha;
    private $tipo;
    private $con;

    public function getMatricula() {
        return $this->matricula;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setMatricula($matricula): void {
        $this->matricula = $matricula;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function consultar() {
        try {
            $this->con = new Conectar();
            if ($this->matricula != "" || $this->matricula != NULL) {
                $sql = "SELECT * FROM docente where matricula_docente = ? AND senha = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $this->matricula, PDO::PARAM_INT);
                $ligacao->bindValue(2, sha1($this->senha), PDO::PARAM_STR);
            }

            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarAdmin() {
        try {
            $this->con = new Conectar();
            if ($this->matricula != "" || $this->matricula != NULL) {
                $sql = "SELECT * FROM usuario where id = ? AND senha = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $this->matricula, PDO::PARAM_INT);
                $ligacao->bindValue(2, sha1($this->senha), PDO::PARAM_STR);
            }

            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarAluno() {
        try {
            $this->con = new Conectar();
            if ($this->matricula != "" || $this->matricula != NULL) {
                $sql = "SELECT * FROM aluno where ra_aluno = ? AND senha = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $this->matricula, PDO::PARAM_INT);
                $ligacao->bindValue(2, sha1($this->senha), PDO::PARAM_STR);
            }

            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function trocarSenha($tipoUsuario) {
        try {
            $this->con = new Conectar();

            if ($tipoUsuario > 0) {
                $sql = "UPDATE docente SET senha = ? WHERE matricula_docente = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, sha1($this->senha), PDO::PARAM_STR);
                $ligacao->bindValue(2, $this->matricula, PDO::PARAM_INT);
                return $ligacao->execute() == 1 ? $ligacao->fetchAll() : false;
            } else {
                $sql = "UPDATE aluno SET senha = ? WHERE ra_aluno = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, sha1($this->senha), PDO::PARAM_STR);
                $ligacao->bindValue(2, $this->matricula, PDO::PARAM_INT);
                return $ligacao->execute() == 1 ? $ligacao->fetchAll() : false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
