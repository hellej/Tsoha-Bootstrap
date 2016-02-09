INSERT INTO Ryhma (nimi, kuvaus, luontiaika)
VALUES('aktiivit', 'semmoset jotka tekee', NOW());

INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja)
VALUES('hellej', 'Joose Helle', 'helle@helsinki.fi', 'asdfj', TRUE);

INSERT INTO Ryhmakayttaja (ryhma_id, kayttaja_id)
VALUES(1,1);


INSERT INTO Kirjoittaja (kayttaja_id) VALUES(1);

INSERT INTO Aihe (nimi, luontiaika, luoja_id) VALUES('varasto', NOW(), 1);

INSERT INTO Keskustelu(otsikko, aika, kirjoittaja_id) 
VALUES('uusi kahvinkeitin', NOW(), 1);

INSERT INTO Keskusteluaihe(aihe_id, keskustelu_id)
VALUES(1,1);

INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('hankitaaks espressokone', NOW(), 1, 1);