INSERT INTO Ryhma (nimi, kuvaus, luontiaika)
VALUES('aktiivit', 'semmoset jotka tekee', NOW());

INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, ryhma_id)
VALUES('hellej', 'Joose Helle', 'helle@helsinki.fi', 'asdfj', TRUE, '1');

INSERT INTO Lukija (kayttaja_id) VALUES(1);
INSERT INTO Kirjoittaja (kayttaja_id) VALUES(1);

INSERT INTO Aihe (nimi, luontiaika) VALUES('varasto', NOW());

INSERT INTO Keskustelu(otsikko, aika, kirjoittaja_id, aihe_id) 
VALUES('uusi kahvinkeitin', NOW(), 1, 1);

INSERT INTO Viesti(sisalto, aika, keskustelu_id, kirjoittaja_id, lukija_id)
VALUES('hankitaaks espressokone', NOW(), 1, 1, 1);