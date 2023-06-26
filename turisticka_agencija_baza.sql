CREATE DATABASE IF NOT EXISTS turisticka_agencija;
USE turisticka_agencija;

CREATE TABLE if NOT EXISTS polise_osiguranja
 (
	idPolise INT(11) NOT NULL AUTO_INCREMENT,
	imeNosiocaOsiguranja VARCHAR(50) NOT NULL,
	prezimeNosiocaOsiguranja VARCHAR(50) NOT NULL,
	vrstaPolise ENUM('individualna','grupna') NOT NULL CHECK (vrstaPolise IN ('individualna','grupna')) COMMENT 'vrstaPolise moze biti individualna ili grupna',
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
	idBloga INT(11) NOT NULL AUTO_INCREMENT,
	naslov VARCHAR(255) NOT NULL,
	opis VARCHAR(255) NOT NULL,
	tekst TEXT NOT NULL,
	fotografija TEXT NOT NULL,
	tipObjave ENUM('blog','vest') NOT NULL CHECK (tipObjave IN ('blog','vest')) COMMENT 'tipObjave moze biti blog ili vest',
	datumKreiranja TIMESTAMP NOT NULL,
	autor VARCHAR(255) NOT NULL,
	statusBloga ENUM('objavljeno', 'uPripremi', 'arhivirano') NOT NULL CHECK (statusBloga IN ('objavljeno', 'uPripremi', 'arhivirano'))
	COMMENT 'statusBloga moze biti objavljeno, uPripremi ili arhivirano',
	datumObjavljivanja DATETIME NULL,
	datumArhiviranja DATETIME NULL,
	PRIMARY KEY (idBloga)
);


CREATE TABLE if NOT EXISTS korisnici
(
	idKorisnik INT(11) NOT NULL AUTO_INCREMENT,
	imeKorisnika VARCHAR(50) NOT NULL,
	prezimeKorisnika VARCHAR(50) NOT NULL,
	korisnickoIme VARCHAR(100) NOT NULL,
	lozinkaKorisnika VARCHAR(30) NOT NULL,
	role ENUM('korisnik', 'admin') NOT NULL DEFAULT 'korisnik' COMMENT 'ROLE moze biti admin ili korisnik', 
	PRIMARY KEY (idKorisnik)
);
INSERT INTO korisnici (imeKorisnika, prezimeKorisnika, korisnickoIme, lozinkaKorisnika, role)
VALUES ('Savo', 'Novakovic', 'admin', 'admin', 'admin');






