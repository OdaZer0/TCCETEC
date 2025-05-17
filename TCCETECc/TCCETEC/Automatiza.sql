CREATE DATABASE Automatiza;
USE Automatiza;

CREATE TABLE Usuario (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    CR INT UNIQUE,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250),
    Cpf VARCHAR(14) UNIQUE,
    Cep VARCHAR(9),
    Avisos INT(3) DEFAULT 0,
    Foto BLOB
);

CREATE TABLE Autonomo (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    CR INT UNIQUE,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250),
    Cpf VARCHAR(14) UNIQUE,
    Cep VARCHAR(9),
    AreaAtuacao VARCHAR(20),
    NivelFormacao VARCHAR(20),
    Avisos INT(3) DEFAULT 0,
    Foto BLOB
);

CREATE TABLE ServicoAutonomo (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(100) NOT NULL,
    Descricao TEXT,
    Tipo VARCHAR(50),
    Valor DECIMAL(10,2),
    Domicilio BOOLEAN DEFAULT 0,
    DataCadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('pendente', 'confirmado', 'concluído') DEFAULT 'pendente',
    IdAutonomo INT NOT NULL,
    IdCliente INT,
    MesConclusao INT,    
    AnoConclusao INT,   
    FOREIGN KEY (IdAutonomo) REFERENCES Autonomo(Id),
    FOREIGN KEY (IdCliente) REFERENCES Usuario(Id)
);

CREATE TABLE Avaliacao (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    AutonomoId INT NOT NULL,
    IdCliente INT NOT NULL,
    Estrela INT NOT NULL CHECK (Estrela BETWEEN 1 AND 5),
    Comentario TEXT,
    DataAvaliacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AutonomoId) REFERENCES Autonomo(Id),
    FOREIGN KEY (IdCliente) REFERENCES Usuario(Id)
);

CREATE TABLE SolicitacoesServico (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    IdServico INT NOT NULL,
    IdUsuario INT NOT NULL,
    IdAutonomo INT NOT NULL,
    DataSolicitada DATE NOT NULL,
    Status ENUM('pendente', 'aceito', 'recusado', 'concluído') DEFAULT 'pendente',
    FOREIGN KEY (IdServico) REFERENCES ServicoAutonomo(Id),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(Id),
    FOREIGN KEY (IdAutonomo) REFERENCES Autonomo(Id)
);

CREATE TABLE Administrador (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Email VARCHAR(60),
    Senha VARCHAR(250),
    Cpf VARCHAR(14) UNIQUE,
    Cep VARCHAR(9),
    Cargo VARCHAR(20),
    Foto BLOB
);

CREATE TABLE ReclamaoDenuncia (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Tipo ENUM('Denúncia de Usuário', 'Denúncia de Autônomo', 'Denúncia Geral', 'Bug', 'Sugestão', 'Reclamação do Sistema') NOT NULL,
    Descricao TEXT NOT NULL,
    Data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CR_QuemReclamou INT NOT NULL,
    CR_Acusado INT,
    Status ENUM('Pendente', 'Resolvido') DEFAULT 'Pendente'
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
drop database Automatiza;
desc Usuario;
Select * From Autonomo;
Select * From Administrador;
Select * From Usuario;
Select* From SolicitacoesServico;
drop table ServicoAutonomo;
Delete from Usuario Where CR > 1;
Select * From Avaliacao;
Select * From ReclamaoDenuncia;
SELECT * FROM ReclamaoDenuncia WHERE Status != 'Resolvido' ORDER BY Data DESC;
SELECT * FROM ServicoAutonomo;




