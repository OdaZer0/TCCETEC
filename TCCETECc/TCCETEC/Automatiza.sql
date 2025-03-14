CREATE DATABASE Automatiza;
USE Automatiza;

CREATE TABLE Usuario (
    Id INT(3) PRIMARY KEY auto_increment,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8) -- Somente números
);

CREATE TABLE Autonomo (
    Id INT(3) PRIMARY KEY,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8), -- Somente números
    AreaAtuacao VARCHAR(20),
    NivelFormacao VARCHAR(20)
);

CREATE TABLE Administrador (
    Id INT PRIMARY KEY,                -- 'INT' sem o tamanho (não é necessário)
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250),                -- Tamanho alto devido à criptografia
    Cpf BIGINT UNIQUE,                 -- 'BIGINT' sem o tamanho
    Cep INT,                           -- 'INT' sem o tamanho
    Cargo VARCHAR(20)
);

SHOW TABLES;
desc Usuario;
Select * From Usuario;
