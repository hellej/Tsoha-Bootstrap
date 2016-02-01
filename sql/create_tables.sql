-- Lisää CREATE TABLE lauseet tähän tiedostoon


CREATE TABLE Ryhma(
id SERIAL PRIMARY KEY,
nimi varchar(40) NOT NULL,
kuvaus varchar(400) NOT NULL,
luontiaika timestamp
);


CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY,
ktunnus varchar(15) NOT NULL,
nimi varchar(30) NOT NULL,
sposti varchar(30),
salasana varchar(15) NOT NULL,
yllapitaja boolean DEFAULT FALSE,
ryhma_id INTEGER REFERENCES Ryhma(id)
);


CREATE TABLE Kirjoittaja(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id)
);


CREATE TABLE Lukija(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id)
);


CREATE TABLE Aihe(
id SERIAL PRIMARY KEY,
nimi varchar(30),
luontiaika date
);

CREATE TABLE Keskustelu(
id SERIAL PRIMARY KEY,
otsikko varchar(40) NOT NULL,
aika timestamp,
kirjoittaja_id INTEGER REFERENCES Kirjoittaja(id),
aihe_id INTEGER REFERENCES Aihe(id)
);


CREATE TABLE Viesti(
id SERIAL PRIMARY KEY,
sisalto varchar(400) NOT NULL,
aika timestamp,
keskustelu_id INTEGER REFERENCES Keskustelu(id),
kirjoittaja_id INTEGER REFERENCES Kirjoittaja(id),
lukija_id INTEGER REFERENCES Lukija(id)
);
