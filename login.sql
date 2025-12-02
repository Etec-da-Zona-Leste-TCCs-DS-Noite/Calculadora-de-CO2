CREATE DATABASE login;
USE login;

CREATE TABLE usuario (
    cod INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(200) NOT NULL
);

CREATE TABLE Conta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cod_user INT NOT NULL,
    nome VARCHAR(100),
    email VARCHAR(255),
    senha VARCHAR (15),
    FOREIGN KEY (cod_user)
        REFERENCES usuario (cod)
);