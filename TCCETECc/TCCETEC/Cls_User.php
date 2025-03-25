<?php
include "conexao.php";
class Gravar {
    private $nome, $email, $senha, $cpf, $cep, $cr;

    public function setnome($nome){
        $this->nome = $nome;
    }
    public function getnome(){
        return $this->nome;
    }
    public function setemail($email){
        $this->email = $email;
    }
    public function getemail(){
        return $this->email;
    }
    public function setsenha($senha){
        $this->senha = $senha;
    }
    public function getsenha(){
        return $this->senha;
    }
    public function setcpf($cpf){
        $this->cpf = $cpf;
    }
    public function getcpf(){
        return $this->cpf;
    }
    public function setcep($cep){
        $this->cep = $cep;
    }
    public function getcep(){
        return $this->cep;
    }
    public function setcr($cr){
        $this->cr = $cr;
    }
    public function getcr(){
        return $this->cr;
    }
}
class GravarPr {
    // Função para gerar um CR único de 5 dígitos
    private function gerarCodigoRegistro($con) {
        do {
            $cr = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $sql = "SELECT COUNT(*) FROM Usuario WHERE cr = ?";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(1, $cr);
            $stmt->execute();
            $existe = $stmt->fetchColumn();
        } while ($existe > 0); // Garante que o CR seja único

        return $cr;
    }

    public function cadastrar(Gravar $a) {
        $bd = new Conexao();
        $con = $bd->getConexao();

        // Gerar um CR único antes de inserir no banco
        $cr = $this->gerarCodigoRegistro($con);
        $a->setcr($cr);

        $sql = "INSERT INTO Usuario (cr, Nome, Email, Senha, Cpf, Cep) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $a->getcr());
        $stmt->bindValue(2, $a->getnome());
        $stmt->bindValue(3, $a->getemail());
        $stmt->bindValue(4, $a->getsenha());
        $stmt->bindValue(5, $a->getcpf());
        $stmt->bindValue(6, $a->getcep());

        if ($stmt->execute()) {
            return "Cadastrado com Sucesso!";
        } else {
            return "Erro ao Cadastrar! Erro: " . implode(",", $stmt->errorInfo());
        }
    }

    public function ultimoIdInserido() {
        return Conexao::getConexao()->lastInsertId();
    }
}
