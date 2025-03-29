CREATE DATABASE Automatiza;
USE Automatiza;

CREATE TABLE Usuario (
    Id INT(3) PRIMARY KEY auto_increment,
    CR int Unique,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8), -- Somente números
    Avisos Int(3) default 0
);

CREATE TABLE Autonomo (
    Id INT(3) PRIMARY KEY auto_increment,
    CR INT Unique,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8), -- Somente números
    AreaAtuacao VARCHAR(20),
    NivelFormacao VARCHAR(20),
    Avisos Int(3) default 0
);

CREATE TABLE Administrador (
    Id INT PRIMARY KEY auto_increment,                -- 'INT' sem o tamanho (não é necessário)
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250),                -- Tamanho alto devido à criptografia
    Cpf BIGINT UNIQUE,                 -- 'BIGINT' sem o tamanho
    Cep INT,                           -- 'INT' sem o tamanho
    Cargo VARCHAR(20)
);

CREATE DATABASE chat_app;

USE chat_app;

CREATE TABLE mensagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SHOW TABLES;
desc Usuario;
Select * From Usuario;
Select * From Autonomo;
Select* From Administrador;
drop table Autonomo;

