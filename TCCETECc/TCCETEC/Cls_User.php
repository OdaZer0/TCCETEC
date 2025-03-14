<?php
include "conexao.php";
class Gravar{
    private $nome, $email, $senha, $cpf, $cep;
    public function setnome($nome){
        $this -> nome = $nome;
    }
    public function getnome(){
        return $this -> nome;
    }
    public function setemail($email){
        $this -> email = $email;}
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
}
class GravarPr{
    public function cadastrar(Gravar $a){
        $bd = new Conexao();
        $con = $bd ->getConexao();
        $sql= "INSERT INTO Usuario (Nome, Email, Senha, Cpf, Cep)
         VALUES(?,?,?,?,?)";
        $stmt = $con -> prepare($sql);
        $stmt -> bindValue(1, $a -> getnome());
        $stmt -> bindValue(2, $a -> getemail());
        $stmt -> bindValue(3, $a -> getsenha());
        $stmt -> bindValue(4, $a -> getcpf());
        $stmt -> bindValue(5, $a -> getcep());

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