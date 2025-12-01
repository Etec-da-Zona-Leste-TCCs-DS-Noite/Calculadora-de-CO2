CREATE DATABASE login;
USE login;

CREATE TABLE usuario (
    cod INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(200) NOT NULL
);

CREATE TABLE conexao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cod_user INT NOT NULL,
    nome VARCHAR(100),
    descricao VARCHAR(255),
    FOREIGN KEY (cod_user)
        REFERENCES usuario (cod)
);