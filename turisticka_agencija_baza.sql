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
-- Unos podataka u tabelu "polise_osiguranja"
INSERT INTO polise_osiguranja (imeNosiocaOsiguranja, prezimeNosiocaOsiguranja, vrstaPolise, telefon, datumPutovanjaOd, datumPutovanjaDo, dodatniPodaci)
VALUES
  ('Marko', 'Marković', 'individualno', '123456789', '2023-06-20 00:00:00', '2023-06-25 00:00:00', 'Dodatni podaci 1'),
  ('Ana', 'Anić', 'grupno', '987654321', '2023-07-01 00:00:00', '2023-07-10 00:00:00', 'Dodatni podaci 2'),
  ('Jovan', 'Jovanović', 'individualno', '555666777', '2023-08-15 00:00:00', '2023-08-20 00:00:00', NULL),
  ('Mila', 'Milić', 'individualno', '111222333', '2023-09-05 00:00:00', '2023-09-10 00:00:00', 'Dodatni podaci 3'),
  ('Nikola', 'Nikolić', 'grupno', '999000111', '2023-07-20 00:00:00', '2023-07-30 00:00:00', 'Dodatni podaci 4'),
  ('Sara', 'Sarić', 'individualno', '444555666', '2023-08-01 00:00:00', '2023-08-07 00:00:00', NULL),
  ('Petar', 'Petrović', 'individualno', '777888999', '2023-09-10 00:00:00', '2023-09-20 00:00:00', 'Dodatni podaci 5'),
  ('Milica', 'Milićević', 'individualno', '222333444', '2023-07-15 00:00:00', '2023-07-25 00:00:00', 'Dodatni podaci 6'),
  ('Luka', 'Lukić', 'grupno', '666777888', '2023-08-10 00:00:00', '2023-08-15 00:00:00', NULL),
  ('Jelena', 'Jelenić', 'individualno', '888999000', '2023-09-15 00:00:00', '2023-09-25 00:00:00', 'Dodatni podaci 7');

-- Unos podataka u tabelu "osiguranici"
INSERT INTO osiguranici (idPolise, ime, prezime, datumRodjenja)
VALUES
  (1, 'Osiguranik 1', 'Prezime 1', '1990-01-01'),
  (1, 'Osiguranik 2', 'Prezime 2', '1995-05-05'),
  (1, 'Osiguranik 3', 'Prezime 3', '1988-10-10'),
  (2, 'Osiguranik 4', 'Prezime 4', '1992-02-02'),
  (2, 'Osiguranik 5', 'Prezime 5', '1987-07-07'),
  (3, 'Osiguranik 6', 'Prezime 6', '1998-03-03'),
  (4, 'Osiguranik 7', 'Prezime 7', '1993-06-06'),
  (5, 'Osiguranik 8', 'Prezime 8', '1996-04-04'),
  (6, 'Osiguranik 9', 'Prezime 9', '1991-09-09'),
  (7, 'Osiguranik 10', 'Prezime 10', '1989-12-12');



