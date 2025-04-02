CREATE DATABASE Automatiza;
USE Automatiza;

CREATE TABLE Usuario (
    Id INT(3) PRIMARY KEY auto_increment,
    CR INT UNIQUE,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8), -- Somente números
    Avisos INT(3) DEFAULT 0,
    Foto BLOB -- Armazena a foto como dados binários
);

CREATE TABLE Autonomo (
    Id INT(3) PRIMARY KEY auto_increment,
    CR INT UNIQUE,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT(11) UNIQUE, -- Somente números
    Cep INT(8), -- Somente números
    AreaAtuacao VARCHAR(20),
    NivelFormacao VARCHAR(20),
    Avisos INT(3) DEFAULT 0,
    Foto BLOB -- Armazena a foto como dados binários
);

CREATE TABLE Administrador (
    Id INT PRIMARY KEY auto_increment, -- 'INT' sem o tamanho (não é necessário)
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250), -- Tamanho alto devido à criptografia
    Cpf BIGINT UNIQUE, -- 'BIGINT' sem o tamanho
    Cep INT, -- 'INT' sem o tamanho
    Cargo VARCHAR(20),
    Foto BLOB -- Armazena a foto como dados binários
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
drop table Administrador;

INSERT INTO Autonomo (CR, Nome, Email, Senha, Cpf, Cep, AreaAtuacao, NivelFormacao, Avisos)
VALUES
(123456, 'João Silva', 'joao.silva@gmail.com', 'senha123', 12345678901, 12345678, 'TI', 'Superior', 0),
(234567, 'Maria Oliveira', 'maria.oliveira@yahoo.com', 'senha123', 98765432100, 23456789, 'Saúde', 'Médio', 1),
(345678, 'Carlos Souza', 'carlos.souza@hotmail.com', 'senha123', 11223344556, 34567890, 'Educação', 'Superior', 0),
(456789, 'Ana Costa', 'ana.costa@gmail.com', 'senha123', 99887766554, 45678901, 'Gestão', 'Médio', 2),
(567890, 'Paulo Pereira', 'paulo.pereira@outlook.com', 'senha123', 88776655443, 56789012, 'TI', 'Superior', 0),
(678901, 'Fernanda Lima', 'fernanda.lima@bol.com.br', 'senha123', 99887766543, 67890123, 'Saúde', 'Superior', 0),
(789012, 'Rafael Alves', 'rafael.alves@globo.com', 'senha123', 55667788999, 78901234, 'Logística', 'Médio', 1),
(890123, 'Bruna Martins', 'bruna.martins@terra.com.br', 'senha123', 66778899001, 89012345, 'Marketing', 'Superior', 0),
(901234, 'Lucas Santos', 'lucas.santos@gmail.com', 'senha123', 22334455667, 90123456, 'Comércio', 'Médio', 2),
(101234, 'Juliana Rocha', 'juliana.rocha@uol.com.br', 'senha123', 33445566778, 10234567, 'Educação', 'Superior', 0);

