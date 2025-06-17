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


SHOW TABLES;
drop database Automatiza;
desc Usuario;
Select * From Autonomo;
Select * From Administrador;
Select * From Usuario;
Select* From SolicitacoesServico;
drop table ServicoAutonomo;
Delete from Avaliacao Where IdCliente =11;
Select * From Avaliacao;
Select * From ReclamaoDenuncia;
SELECT * FROM ReclamaoDenuncia WHERE Status != 'Resolvido' ORDER BY Data DESC;
SELECT * FROM ServicoAutonomo;
Delete From Autonomo Where CR > 1;
INSERT INTO Usuario (CR, Nome, Email, Senha, Cpf, Cep, Avisos, Foto) VALUES
(10001, 'João da Silva', 'joao.silva@email.com', 'senha123', '123.456.789-00', '01001-000', 1, NULL),
(10002, 'Maria Oliveira', 'maria.oliveira@email.com', 'senha456', '987.654.321-00', '02002-000', 0, NULL),
(10003, 'Carlos Souza', 'carlos.souza@email.com', 'senha789', '321.654.987-00', '03003-000', 2, NULL),
(10004, 'Fernanda Lima', 'fernanda.lima@email.com', 'segura123', '456.789.123-00', '04004-000', 1, NULL),
(10005, 'Ricardo Alves', 'ricardo.alves@email.com', 'ricardo456', '654.321.987-00', '05005-000', 0, NULL),
(10006, 'Juliana Rocha', 'juliana.rocha@email.com', 'senha987', '159.357.258-00', '06006-000', 3, NULL),
(10007, 'Pedro Martins', 'pedro.martins@email.com', 'pedro321', '753.951.456-00', '07007-000', 0, NULL),
(10008, 'Tatiane Reis', 'tatiane.reis@email.com', 'tatipass', '852.456.123-00', '08008-000', 1, NULL),
(10009, 'Luciano Pires', 'luciano.pires@email.com', 'lucpass', '951.753.456-00', '09009-000', 0, NULL),
(10010, 'Camila Duarte', 'camila.duarte@email.com', 'camilasenha', '258.456.159-00', '10010-000', 2, NULL);
INSERT INTO Autonomo (CR, Nome, Email, Senha, Cpf, Cep, AreaAtuacao, NivelFormacao, Avisos, Foto) VALUES
(20001, 'Ana Paula', 'ana.paula@email.com', 'autonomo123', '111.222.333-44', '11001-000', 'Psicologia', 'Mestrado', 0, NULL),
(20002, 'Bruno Lima', 'bruno.lima@email.com', 'autonomo456', '555.666.777-88', '12002-000', 'Fisioterapia', 'Graduação', 1, NULL),
(20003, 'Larissa Mendes', 'larissa.mendes@email.com', 'larissa789', '999.888.777-66', '13003-000', 'Terapia Ocupacional', 'Pós-graduação', 0, NULL),
(20004, 'Eduardo Teles', 'edu.teles@email.com', 'edu321', '333.222.111-00', '14004-000', 'Nutrição', 'Mestrado', 2, NULL),
(20005, 'Mariana Castro', 'mariana.castro@email.com', 'maripass', '444.555.666-77', '15005-000', 'Psicopedagogia', 'Doutorado', 0, NULL),
(20006, 'Felipe Santos', 'felipe.santos@email.com', 'felipepass', '777.888.999-00', '16006-000', 'Educação Física', 'Graduação', 1, NULL),
(20007, 'Renata Dias', 'renata.dias@email.com', 'renata321', '222.333.444-55', '17007-000', 'Fonoaudiologia', 'Pós-graduação', 0, NULL),
(20008, 'Thiago Rocha', 'thiago.rocha@email.com', 'thiagopass', '666.777.888-99', '18008-000', 'Psicologia', 'Graduação', 1, NULL),
(20009, 'Beatriz Nogueira', 'beatriz.nogueira@email.com', 'bea123', '111.333.555-77', '19009-000', 'Serviço Social', 'Mestrado', 2, NULL),
(20010, 'André Barbosa', 'andre.barbosa@email.com', 'andrepass', '888.999.000-11', '20010-000', 'Psicologia', 'Doutorado', 0, NULL);
INSERT INTO Administrador (Nome, Email, Senha, Cpf, Cep, Cargo, Foto)
VALUES (
    'João Silva', 
    'ADM@gmail', 
    '123', 
    '123.456.789-00', 
    '12345-678', 
    'Administrador', 
    NULL
);






