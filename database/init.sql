-- Active: 1745057190962@@127.0.0.1@3306@all_shop

-- Creazione Database
CREATE DATABASE all_shop;
use all_shop;

-- Creazione tabelle
CREATE TABLE clienti(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    data_registrazione date not NULL,
    password VARCHAR(255) not NULL
);

CREATE TABLE admin(
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) not NULL
);

CREATE TABLE categorie (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) UNIQUE NOT NULL
);

CREATE Table prodotti(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    id_categoria INT NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    check(prezzo >= 0),
    check(stock >= 0),
    FOREIGN key(id_categoria) REFERENCES categorie(id)
);

CREATE Table ordini(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente int NOT NULL,
    data_ordine date NOT NULL,
    FOREIGN KEY(id_cliente) REFERENCES clienti(id)
);

CREATE TABLE ordini_prodotti(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ordine INT NOT NULL,
    id_prodotto INT NOT NULL,
    qt_prodotto INT NOT NULL,
    FOREIGN KEY(id_ordine) REFERENCES ordini(id),
    FOREIGN KEY(id_prodotto) REFERENCES prodotti(id),
    check(qt_prodotto > 0)
);

CREATE TABLE carrello(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_prodotto INT not NULL,
    qt_prodotto INT not NULL,
    id_cliente INT NOT NULL,
    check(qt_prodotto > 0),
    FOREIGN KEY(id_prodotto) REFERENCES prodotti(id),
    FOREIGN KEY(id_cliente) REFERENCES clienti(id)
);


-- Popolamento tabelle
-- password 1 https://bcrypt-generator.com/
INSERT INTO admin(email, password) VALUES('angela@email.com', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.');

INSERT INTO categorie (nome) VALUES
('Abbigliamento e Moda'),
('Accessori'),
('Alimentari e Bevande'),
('Audio'),
('Auto e Moto'), 
('Casa e Arredamento'),
('Cura della persona e Bellezza'),
('Giocattoli e Bambini'),
('Informatica'),
('Libri, Film e Musica'),
('Periferiche'),
('Rete'),
('Sport e Tempo Libero'),
('Storage'),
('Tablet'),
('Telefonia');

INSERT INTO prodotti (nome, id_categoria, prezzo, stock) VALUES
('Notebook Lenovo IdeaPad 3', 9, 549.99, 105),
('Mouse Logitech M185', 2, 14.99, 50),
('Smartphone Samsung Galaxy A14', 16, 199.90, 25),
('Stampante HP DeskJet 2710e', 11, 69.90, 15),
('Cuffie Sony WH-CH520', 4, 49.99, 30),
('Tastiera meccanica Redragon', 2, 39.90, 20),
('Monitor LG 24" Full HD', 9, 129.99, 12),
('Hard Disk Esterno 1TB Toshiba', 14, 59.90, 18),
('Chiavetta USB 64GB Kingston', 14, 9.90, 60),
('Router TP-Link Archer C6', 12, 44.99, 17),
('Tablet Apple iPad 10.2"', 15, 389.00, 8),
('Caricabatterie Universale USB-C', 2, 24.90, 35),
('Webcam Logitech C270', 11, 29.99, 22),
('Scheda SD 128GB SanDisk', 14, 17.99, 40),
('Altoparlante Bluetooth JBL GO 3', 4, 39.99, 14);

INSERT INTO clienti (nome, cognome, email, data_registrazione, password) VALUES
('Mario', 'Rossi', 'mario.rossi@email.com', '2023-01-15', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.'),
('Luca', 'Bianchi', 'luca.bianchi@email.com', '2023-03-22', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.'),
('Anna', 'Verdi', 'anna.verdi@email.com', '2023-05-10', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.'),
('Giulia', 'Neri', 'giulia.neri@email.com', '2023-07-05', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.'),
('Marco', 'Gialli', 'marco.gialli@email.com', '2023-08-18', '$2a$12$JCiUq1jT5cNIoHFYYygwEOXDej/pWyiQu2zDAT5mncUUT7XHqPmu.');

INSERT INTO ordini (id_cliente, data_ordine) VALUES
(1, '2023-02-01'),
(1, '2023-02-20'),
(2, '2023-04-01'),
(3, '2023-06-15'),
(4, '2023-08-01'),
(5, '2023-09-12');

INSERT INTO ordini_prodotti (id_ordine, id_prodotto, qt_prodotto) VALUES
(1, 1, 5),
(1, 2, 1),
(2, 3, 2),
(3, 4, 2),
(3, 5, 5),
(4, 6, 2),
(4, 7, 1),
(5, 8, 2),
(5, 9, 5),
(6, 10, 8),
(6, 11, 7),
(6, 12, 6);