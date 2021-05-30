CREATE DATABASE IF NOT EXISTS Scuole_In_Sicurezza;

CREATE TABLE IF NOT EXISTS Utenti(
	id_utente INT PRIMARY KEY AUTO_INCREMENT,
    approvazione SET('sì','no') NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    cf CHAR(16) NOT NULL,
    ruolo SET('Dirigenza','Segreteria','Insegnanti','Responsabile Covid','Amministrazione') NOT NULL,
    telefono char(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nazione VARCHAR(255) NOT NULL,
    città VARCHAR(255) NOT NULL,
    provincia VARCHAR(255) NOT NULL,
    via VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Classi(
	id_classe INT PRIMARY KEY AUTO_INCREMENT,
    numero INT NOT NULL,
    sezione VARCHAR(5) NOT NULL
);    

CREATE TABLE Alunni (
  id_alunno int(11) NOT NULL,
  nome varchar(255) NOT NULL,
  cognome varchar(255) NOT NULL,
  telefono_genitore char(10) NOT NULL,
  email_genitore varchar(255) NOT NULL,
  id_classe int(11) NOT NULL
);

ALTER TABLE Alunni
  ADD PRIMARY KEY (id_alunno),
  ADD KEY id_classe (id_classe);

ALTER TABLE Alunni
  MODIFY id_alunno int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS Device(
	id int(11) PRIMARY KEY  NOT NULL,
    btmac varchar(17) UNIQUE KEY NOT NULL,
    status int(11) NOT NULL,
    timestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

CREATE TABLE Proxy(
    mybtmac VARCHAR(17) NOT NULL,
    otherbtmac VARCHAR(17) NOT NULL,
    timestamp timestamp,
    primary key (btmac, otherbtmac,timestamp),
    status INT(11) NOT NULL,
    duration INT NOT NULL
);


CREATE TABLE IF NOT EXISTS Insegnano (
    id_utente INT,
    id_classe INT,
    primary key (id_utente, id_classe)
);

CREATE TABLE IF NOT EXISTS allarmi_in_corso(
    btmac1 varchar(17) NOT NULL,
    btmac2 varchar(17) NOT NULL,
    primary key (btmac1, btmac2)
);

ALTER TABLE Insegnano ADD FOREIGN KEY (id_utente) REFERENCES Utenti(id_utente);
ALTER TABLE Insegnano ADD FOREIGN KEY (id_classe) REFERENCES Classi(id_classe);

ALTER TABLE Alunni ADD FOREIGN KEY (id_classe) REFERENCES Classi(id_classe);
ALTER TABLE Device ADD FOREIGN KEY (id) REFERENCES Alunni(id_alunno);


ALTER TABLE Proxy ADD FOREIGN KEY (mybtmac) REFERENCES Device(btmac);
ALTER TABLE Proxy ADD FOREIGN KEY (otherbtmac) REFERENCES Device(btmac);


ALTER TABLE allarmi_in_corso
  ADD CONSTRAINT allarmi_in_corso_ibfk_1 FOREIGN KEY (btmac1) REFERENCES Device (btmac),
  ADD CONSTRAINT allarmi_in_corso_ibfk_2 FOREIGN KEY (btmac2) REFERENCES Device (btmac);

CREATE VIEW temp as
		SELECT a.btmac1 as bt , a.btmac2 as bt2
		FROM allarmi_in_corso a 
		WHERE a.btmac1 <= a.btmac2
		UNION ALL
		SELECT b.btmac1 as bt , b.btmac2 as bt2
		FROM allarmi_in_corso b 
		WHERE b.btmac1 > b.btmac2 AND NOT EXISTS (SELECT 1 FROM allarmi_in_corso t2 WHERE t2.btmac1= b.btmac2 AND t2.btmac2 =b.btmac1);  