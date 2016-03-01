<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vastine extends BaseModel {

    public $id, $sisalto, $aika, $keskustelu_id, $kirjoittaja_id, $kirjoittaja_ktunnus, $keskustelu_otsikko;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('validate_vastine');
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT Vastine.id, Vastine.sisalto, Vastine.aika, Vastine.keskustelu_id, Vastine.kirjoittaja_id, Kayttaja.ktunnus, Keskustelu.otsikko FROM Vastine, Kayttaja, Keskustelu WHERE Vastine.kirjoittaja_id = Kayttaja.id AND Vastine.keskustelu_id = Keskustelu.id ORDER BY Vastine.aika DESC');
        $query->execute();
        $rows = $query->fetchAll();
        $vastineet = array();

        foreach ($rows as $row) {
            $vastineet[] = new Vastine(self::getAttributes($row));
        }
        return $vastineet;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Vastine WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $vastine = new Vastine(self::getAttributes($row));
            return $vastine;
        }

        return null;
    }

    public static function getAttributes($row) {

        $attributes = array(
            'id' => $row['id'],
            'sisalto' => $row['sisalto'],
            'aika' => self::roundTimeStampToTime($row),
            'keskustelu_id' => $row['keskustelu_id'],
            'kirjoittaja_id' => $row['kirjoittaja_id'],
            'kirjoittaja_ktunnus' => $row['ktunnus'],
            'keskustelu_otsikko' => $row['otsikko']);

        return $attributes;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Vastine (sisalto, aika, keskustelu_id, kirjoittaja_id) Values (:sisalto, NOW(), :keskustelu_id, :kirjoittaja_id)');
        $query->execute(array('sisalto' => $this->sisalto, 'keskustelu_id' => $this->keskustelu_id, 'kirjoittaja_id' => $this->kirjoittaja_id));
    }

    public static function allKeskustelu($keskustelu_id) {

        $query = DB::connection()->prepare('SELECT Vastine.id, Vastine.sisalto, Vastine.aika, Vastine.keskustelu_id, Vastine.kirjoittaja_id, Kayttaja.ktunnus, Keskustelu.otsikko FROM Vastine, Kayttaja, Keskustelu WHERE Vastine.kirjoittaja_id = Kayttaja.id AND Vastine.keskustelu_id = Keskustelu.id AND keskustelu_id = :id ORDER BY Vastine.aika ASC');
        $query->execute(array('id' => $keskustelu_id));
        $rows = $query->fetchAll();
        $vastineet = array();

        foreach ($rows as $row) {
            $vastineet[] = new Vastine(self::getAttributes($row));
        }

        return $vastineet;
    }

    public static function getKayttajanVastineidenMaara($kayttaja_id) {

        $query = DB::connection()->prepare('SELECT COUNT(id) FROM Vastine WHERE kirjoittaja_id = :id');
        $query->execute(array('id' => $kayttaja_id));
        $row = $query->fetch();
        $maara = $row['count'];

        return $maara;
    }

    public function getKeskustelunVastineidenMaara($keskustelu_id) {

        $query = DB::connection()->prepare('SELECT COUNT(id) FROM Vastine WHERE keskustelu_id = :id');
        $query->execute(array('id' => $keskustelu_id));
        $row = $query->fetch();
        $maara = $row['count'];

        return $maara;
    }

    public function validate_vastine() {

        return $this->validate_string_length('vastine', $this->sisalto, 1);
    }

}
