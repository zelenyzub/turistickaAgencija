CREATE DATABASE IF NOT EXISTS turisticka_agencija;
USE turisticka_agencija;

CREATE TABLE if NOT EXISTS polise_osiguranja
 (
	idPolise INT(11) NOT NULL AUTO_INCREMENT,
	imeNosiocaOsiguranja VARCHAR(50) NOT NULL,
	prezimeNosiocaOsiguranja VARCHAR(50) NOT NULL,
	vrstaPolise VARCHAR(15) NOT NULL,
	telefon VARCHAR(20) NOT NULL,
	datumPutovanjaOd DATETIME NOT NULL,
	datumPutovanjaDo DATETIME NOT NULL,
	dodatniPodaci VARCHAR(255) NULL,
	PRIMARY KEY (idPolise)
);

CREATE TABLE if NOT EXISTS osiguranici (
	idOsiguranika INT(11) NOT NULL AUTO_INCREMENT,
	idPolise INT(11) NOT NULL,
	ime VARCHAR(50) NOT NULL,
	prezime VARCHAR(50) NOT NULL,
	datumRodjenja DATE NOT NULL,
	PRIMARY KEY (idOsiguranika),
	CONSTRAINT FK__polise_osiguranja FOREIGN KEY (idPolise) REFERENCES polise_osiguranja (idPolise) ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE if NOT EXISTS blog_vesti
(
	idBloga INT(11) NOT NULL,
	naslov VARCHAR(50) NOT NULL,
	opis VARCHAR(255) NOT NULL,
	tekst TEXT NOT NULL,
	fotogravija VARCHAR(255) NOT NULL,
	tipObjave VARCHAR(50) NOT NULL,
	datumKreiranja DATETIME NOT NULL,
	autor VARCHAR(255) NOT NULL,
	statusBloga VARCHAR(50) NOT NULL,
	datumObjavljivanja DATETIME NOT NULL,
	datumArhiviranja DATETIME NOT NULL,
	PRIMARY KEY (idBloga)
);

CREATE TABLE if NOT EXISTS administrator
(
	idAdmin INT(11) NOT NULL AUTO_INCREMENT,
	imeAdmina VARCHAR(50) NOT NULL,
	prezimeAdmina VARCHAR(50) NOT NULL,
	korisnickoIme VARCHAR(100) NOT NULL,
	lozinka VARCHAR(30) NOT NULL,
	PRIMARY KEY (idAdmin) 
);




