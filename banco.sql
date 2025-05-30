CREATE DATABASE IF NOT EXISTS supermercado;
USE supermercado;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE,
    nome VARCHAR(100),
    preco DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS operadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) UNIQUE
);

CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    operador VARCHAR(100),
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT,
    produto VARCHAR(100),
    preco DECIMAL(10,2),
    quantidade INT
);

INSERT INTO produtos (codigo, nome, preco) VALUES
('7891234567890', 'Arroz 5kg', 22.50),
('7891234567891', 'Feijão 1kg', 8.30),
('7891234567892', 'Macarrão 500g', 5.20);

INSERT INTO operadores (nome) VALUES ('Ana'), ('Carlos');
