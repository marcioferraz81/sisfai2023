<?php

include_once 'Conectar.php';

class Docente {

    private $matricula;
    private $nome;
    private $status;
    private $tipo;
    private $hae;
    private $senha;
    private $con;

    public function getMatricula() {
        return $this->matricula;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getHae() {
        return $this->hae;
    }

    public function setMatricula($matricula): void {
        $this->matricula = $matricula;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setHae($hae): void {
        $this->hae = $hae;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    function salvar() {
        try {
            $this->con = new Conectar();

            $sql = "INSERT INTO docente VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $executar = $this->con->prepare($sql);
            //echo "teste";
            $executar->bindValue(1, $this->matricula);
            $executar->bindValue(2, $this->nome);
            $executar->bindValue(3, $this->status);
            $executar->bindValue(4, $this->tipo);
            $executar->bindValue(5, $this->hae);
            $executar->bindValue(6, sha1($this->matricula));
            $executar->bindValue(7, 0);
            $executar->bindValue(8, 0);
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
            $sql = "UPDATE docente SET nome_docente = ?, status_docente = ?, TipoUsuario_docente = ?, qtdHAE = ? WHERE matricula_docente = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, $this->nome);
            $executar->bindValue(2, $this->status);
            $executar->bindValue(3, $this->tipo);
            $executar->bindValue(4, $this->hae);
            $executar->bindValue(5, $this->matricula);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function alterarSenha() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE docente SET senha = ? WHERE matricula_docente = ?";
            $executar = $this->con->prepare($sql);
            //passar parametros para as interrogações
            $executar->bindValue(1, sha1($this->senha));
            $executar->bindValue(2, $this->matricula);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM docente ORDER BY TipoUsuario_docente DESC, nome_docente ASC";
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
            $sql = "SELECT * FROM docente WHERE matricula_docente = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->matricula);

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
            $sql = "DELETE FROM docente WHERE matricula_docente = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->matricula);

            if ($executar->execute() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function haesPTGPorDocente() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM viewDocentePTG ORDER BY nome ASC";
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

    function haesTGPorDocente() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM viewDocenteTG ORDER BY nome ASC";
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

    function paginar($inicio, $total_reg) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM docente LIMIT $inicio,$total_reg ";
            $executar = $this->con->prepare($sql);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
