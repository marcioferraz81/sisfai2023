<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class Assinatura {

    private $matricula;
    private $arquivo;
    private $temp_arquivo;
    private $con;
    private $ct;
    private $caminho = "../assinatura/";

    public function getMatricula() {
        return $this->matricula;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function getTemp_arquivo() {
        return $this->temp_arquivo;
    }

    public function setMatricula($matricula): void {
        $this->matricula = $matricula;
    }

    public function setArquivo($arquivo): void {
        $this->arquivo = $arquivo;
    }

    public function setTemp_arquivo($temp_arquivo): void {
        $this->temp_arquivo = $temp_arquivo;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = $this->con->prepare("INSERT INTO assinatura VALUES (null, ?, ?)");
            $sql->bindValue(1, $this->matricula, PDO::PARAM_INT);
            $sql->bindValue(2, $this->arquivo, PDO::PARAM_STR);

            return ($sql->execute() == 1 ? TRUE : FALSE);
        } catch (PDOException $exc) {
            echo "Erro ao salvar " . $exc->getMessage();
        }
    }

    function enviarArquivos() {
        $this->ct = new Controles();
        return $this->ct->enviarArquivo($this->temp_arquivo, $this->caminho . $this->arquivo, "Assinatura");
    }

    function consultar() {
        try {
            $this->con = new Conectar();
            $sql = $this->con->prepare("SELECT a.*, d.* "
                    . "FROM assinatura a, docente d "
                    . "WHERE a.matricula_docente = d.matricula_docente");
            return ($sql->execute() == 1 ? $sql->fetchAll() : FALSE);
        } catch (PDOException $exc) {
            echo "Erro ao salvar " . $exc->getMessage();
        }
    }

    function pesquisarPorID() {
        try {
            $this->con = new Conectar();
            $sql = $this->con->prepare("SELECT a.* "
                    . "FROM assinatura a "
                    . "INNER JOIN docente d ON a.matricula_docente = d.matricula_docente "
                    //. "WHERE a.matricula_docente = d.matricula_docente "
                    . "WHERE a.matricula_docente = ?");
            $sql->bindValue(1, $this->matricula, PDO::PARAM_INT);

            return ($sql->execute() == 1 ? $sql->fetchAll() : FALSE);
        } catch (PDOException $exc) {
            echo "Erro ao salvar " . $exc->getMessage();
        }
    }
    
    function consultarMatricula() {
        try {
            $this->con = new Conectar();
            $sql = $this->con->prepare("SELECT a.* "
                    . "FROM assinatura a, docente d "
                    . "WHERE a.matricula_docente = d.matricula_docente "
                    . "AND a.matricula_docente = ? GROUP BY a.matricula_docente");
            $sql->bindValue(1, $this->matricula, PDO::PARAM_INT);

            return ($sql->execute() == 1 ? $sql->fetchAll() : FALSE);
        } catch (PDOException $exc) {
            echo "Erro ao salvar " . $exc->getMessage();
        }
    }

    function pesquisarPorID2() {
        try {
            $this->con = new Conectar();
            $sql = $this->con->prepare("SELECT a.* "
                    . "FROM assinatura a "
                    . "WHERE a.matricula_docente = ?");
            $sql->bindValue(1, $this->matricula, PDO::PARAM_INT);

            return ($sql->execute() == 1 ? $sql->fetchAll() : FALSE);
        } catch (PDOException $exc) {
            echo "Erro ao salvar " . $exc->getMessage();
        }
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $this->ct = new Controles();
            $sql = "DELETE FROM assinatura WHERE matricula_docente = ?";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->matricula);

            foreach ($this->pesquisarPorID() as $mostrar) {
                $this->ct->excluirArquivo($this->caminho . $mostrar[2], "Imagem do produto");
                break;
            }

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
