INSERT INTO Ryhma (nimi, kuvaus, luontiaika)
VALUES('aktiivit', 'semmoset jotka tekee', NOW());
INSERT INTO Ryhma (nimi, kuvaus, luontiaika)
VALUES('hallitus', 'semmoset jotka päättää', NOW());

INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('poistettu_käyttäjä', 'Poistettu Käyttäjä', 'ei sähköpostia', 'salasana', 'FALSE', 'Tämän käyttäjän viestit ovat poistettujen käyttäjätunnusten lähettämiä');
INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('pekka', 'Pekka Lammi', 'pekka@helsinki.fi', 'aurinko', 'FALSE', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius d');
INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('helle', 'Joose Helle', 'helle@helsinki.fi', 'aurinko', 'TRUE', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius d');
INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, yllapitaja, kuvaus)
VALUES('matti', 'Matti Mannonen', 'matti@helsinki.fi', 'aurinko', 'FALSE', 'Lorem ipsum dolor sit ame');
-- INSERT INTO Ryhmakayttaja (ryhma_id, kayttaja_id)
-- VALUES(1,1);

INSERT INTO Aihe (nimi, luontiaika) VALUES('varasto', NOW());

INSERT INTO Keskustelu(otsikko, sisalto, aika, luoja_id) 
VALUES('keskustelu yksi', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti.', NOW(), 2);
INSERT INTO Keskustelu(otsikko, sisalto, aika, luoja_id) 
VALUES('keskustelu kaksi', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti.', NOW(), 2);
INSERT INTO Keskustelu(otsikko, sisalto, aika, luoja_id) 
VALUES('keskustelu kolme', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti.', NOW(), 3);


INSERT INTO Keskusteluaihe(aihe_id, keskustelu_id)
VALUES(1,1);



INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu.', NOW(), 1, 2);
INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu.', NOW(), 3, 3);
INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('Lorem ipsum dolor sit elit. Sed posuere interdum sem. Quisque ligula eru.', NOW(), 1, 3);
INSERT INTO Vastine(sisalto, aika, keskustelu_id, kirjoittaja_id)
VALUES('asdfasdffasdfsadf i sem. Quisque ligula eru.', NOW(), 3, 4);
