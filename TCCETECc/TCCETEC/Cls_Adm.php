<?php
require_once(__DIR__ . '/conexao.php');  // Corrigido para usar caminho absoluto

class Gravar{
    private $nome, $email, $senha, $cpf, $cep, $cargo;
    public function setnome($nome){
        $this -> nome = $nome;
    }
    public function getnome(){
        return $this -> nome;
    }
    public function setemail($email){
        $this -> email = $email;
    }
    public function getemail(){
        return $this -> email;
    }
    public function setsenha($senha){
        $this -> senha = $senha;
    }
    public function getsenha(){
        return $this -> senha;
    }
    public function setcpf($cpf){
        $this -> cpf = $cpf;
    }
    public function getcpf(){
        return $this -> cpf;
    }
    public function setcep($cep){
        $this -> cep = $cep;
    }
    public function getcep(){
        return $this -> cep;
    }
    public function setcargo($cargo){
        $this -> cargo = $cargo;
    }
    public function getcargo(){
        return $this -> cargo;
    }
}

class GravarPr{
    public function cadastrar(Gravar $a){
        $con = Conexao::getConexao();  // Alterado para usar a chamada estática diretamente
        $sql = "INSERT INTO Administrador (Nome, Email, Senha, Cpf, Cep, Cargo)
                VALUES(?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $a->getnome());
        $stmt->bindValue(2, $a->getemail());
        $stmt->bindValue(3, $a->getsenha());
        $stmt->bindValue(4, $a->getcpf());
        $stmt->bindValue(5, $a->getcep());w
        $stmt->bindValue(6, $a->getcargo());

        if ($stmt->execute()){
            return "Cadastrado com Sucesso!";
        } else {
            return "Erro ao Cadastrar! Erro: ". implode(",", $stmt->errorInfo());
        }
    }

    public function ultimoIdInserido() {
        return Conexao::getConexao()->lastInsertId();
    }
}
