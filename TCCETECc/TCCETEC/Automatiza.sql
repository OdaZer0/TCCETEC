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
CREATE TABLE ServicoAutonomo (
    Id INT AUTO_INCREMENT PRIMARY KEY,  -- Chave primária da própria tabela
    Titulo VARCHAR(100),
    Descricao TEXT,
    Tipo VARCHAR(50),
    Valor DECIMAL(10,2),
    Domicilio BOOLEAN,
    IdAutonomo INT,                     -- Este sim é uma Foreign Key
    FOREIGN KEY (IdAutonomo) REFERENCES tb_autonomo(id)
);

CREATE TABLE SolicitacoesServico (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    IdServico INT NOT NULL,
    IdUsuario INT NOT NULL,
    IdAutonomo INT NOT NULL,  -- Agora é referente ao Autônomo da tabela ServicoAutonomo
    DataSolicitada DATE NOT NULL,
    Status ENUM('pendente', 'aceito', 'recusado') DEFAULT 'pendente',
    FOREIGN KEY (IdServico) REFERENCES ServicoAutonomo(Id),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(Id),
    FOREIGN KEY (IdAutonomo) REFERENCES ServicoAutonomo(IdAutonomo)  -- Refere-se à tabela ServicoAutonomo
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
Select* From SolicitacoesServico;
drop table SolicitacoesServico;
Delete from Autonomo Where CR > 1;

INSERT INTO Usuario (CR, Nome, Email, Senha, Cpf, Cep, Avisos, Foto) VALUES
(54321, 'João Silva', 'joao.silva@email.com', 'senhaCriptografada1', 12345678901, 12345678, 0, NULL),
(12345, 'Maria Oliveira', 'maria.oliveira@email.com', 'senhaCriptografada2', 98765432100, 23456789, 1, NULL),
(67890, 'Carlos Pereira', 'carlos.pereira@email.com', 'senhaCriptografada3', 11122233344, 34567890, 0, NULL),
(13579, 'Ana Souza', 'ana.souza@email.com', 'senhaCriptografada4', 55566677788, 45678901, 2, NULL),
(24680, 'Fernanda Lima', 'fernanda.lima@email.com', 'senhaCriptografada5', 99988877766, 56789012, 0, NULL),
(11223, 'Rafael Costa', 'rafael.costa@email.com', 'senhaCriptografada6', 44455566677, 67890123, 1, NULL),
(33445, 'Juliana Rocha', 'juliana.rocha@email.com', 'senhaCriptografada7', 11133355577, 78901234, 0, NULL),
(55667, 'Lucas Martins', 'lucas.martins@email.com', 'senhaCriptografada8', 22244466688, 89012345, 3, NULL),
(77889, 'Patrícia Melo', 'patricia.melo@email.com', 'senhaCriptografada9', 33355577799, 90123456, 0, NULL),
(99001, 'Bruno Alves', 'bruno.alves@email.com', 'senhaCriptografada10', 44466688800, 11234567, 0, NULL);
INSERT INTO Autonomo (CR, Nome, Email, Senha, Cpf, Cep, AreaAtuacao, NivelFormacao, Avisos, Foto) VALUES
(51234, 'Aline Castro', 'aline.castro@email.com', 'senhaCriptografada1', 10101010101, 12345678, 'Enfermagem', 'Superior', 0, NULL),
(67891, 'Marcelo Vieira', 'marcelo.vieira@email.com', 'senhaCriptografada2', 20202020202, 23456789, 'Educação Física', 'Técnico', 1, NULL),
(34985, 'Renata Borges', 'renata.borges@email.com', 'senhaCriptografada3', 30303030303, 34567890, 'Estética', 'Superior', 0, NULL),
(90543, 'Diego Almeida', 'diego.almeida@email.com', 'senhaCriptografada4', 40404040404, 45678901, 'Massoterapia', 'Técnico', 2, NULL),
(22019, 'Larissa Ramos', 'larissa.ramos@email.com', 'senhaCriptografada5', 50505050505, 56789012, 'Nutrição', 'Superior', 0, NULL),
(74125, 'Felipe Duarte', 'felipe.duarte@email.com', 'senhaCriptografada6', 60606060606, 67890123, 'Psicologia', 'Superior', 0, NULL),
(38912, 'Tatiane Lopes', 'tatiane.lopes@email.com', 'senhaCriptografada7', 70707070707, 78901234, 'Fisioterapia', 'Médio', 1, NULL),
(85691, 'Eduardo Lima', 'eduardo.lima@email.com', 'senhaCriptografada8', 80808080808, 89012345, 'Podologia', 'Técnico', 0, NULL),
(19873, 'Camila Ferreira', 'camila.ferreira@email.com', 'senhaCriptografada9', 90909090909, 90123456, 'Estética', 'Superior', 3, NULL),
(67048, 'Vinícius Mendes', 'vinicius.mendes@email.com', 'senhaCriptografada10', 11223344556, 11234567, 'Terapia Ocupacional', 'Superior', 0, NULL);
INSERT INTO Administrador (Nome, Email, Senha, Cpf, Cep, Cargo, Foto) VALUES
('Administrador Master', 'ADM1@gmail', '123', 12345678900, 12345678, 'Coordenador', NULL);



