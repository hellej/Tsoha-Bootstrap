INSERT INTO Ryhma (nimi, kuvaus, luontiaika)
VALUES('aktiivit', 'semmoset jotka tekee', NOW());

INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('hellej', 'Joose Helle', 'helle@helsinki.fi', 'asdfj', 'joo', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius d');
INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('helle', 'Testijamppa', 'helle@helsinki.fi', 'aurinko', 'joo', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius d');

-- INSERT INTO Ryhmakayttaja (ryhma_id, kayttaja_id)
-- VALUES(1,1);

INSERT INTO Aihe (nimi, luontiaika) VALUES('varasto', NOW());

INSERT INTO Keskustelu(otsikko, sisalto, aika, kirjoittaja_id) 
VALUES('keskustelun otsikko', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti.', NOW(), 1);

INSERT INTO Keskustelu(otsikko, sisalto, aika, kirjoittaja_id) 
VALUES('keskustelu kaksi', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti.', NOW(), 1);

INSERT INTO Keskusteluaihe(aihe_id, keskustelu_id)
VALUES(1,1);



INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu.', NOW(), 1, 1);

INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu.', NOW(), 1, 1);