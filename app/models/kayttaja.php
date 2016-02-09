<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kayttaja extends BaseModel {

    public $id, $ktunnus, $nimi, $sposti, $salasana, $yllapitaja;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $row['id'],
                'ktunnus' => $row['ktunnus'],
                'nimi' => $row['nimi'],
                'sposti' => $row['sposti'],
                'salasana' => $row['salasana'],
                'yllapitaja' => $row['yllapitaja']));
        }

        return $kayttajat;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM KAYTTAJA WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'ktunnus' => $row['ktunnus'],
                'nimi' => $row['nimi'],
                'sposti' => $row['sposti'],
                'salasana' => $row['salasana'],
                'yllapitaja' => $row['yllapitaja']));

            return $kayttaja;
        }
        return null;
    }

}
