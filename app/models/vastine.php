<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vastine extends BaseModel {

    public $id, $sisalto, $aika, $keskustelu_id, $kirjoittaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Vastine');
        $query->execute();
        $rows = $query->fetchAll();
        $vastineet = array();

        foreach ($rows as $row) {
            $vastineet[] = new Vastine(array(
                'id' => $row['id'],
                'sisalto' => $row['sisalto'],
                'aika' => $row['aika'],
                'keskustelu_id' => $row['keskustelu_id'],
                'kirjoittaja_id' => $row['kirjoittaja_id']
            ));
        }
        return $vastineet;
    }

    public static function allKeskustelu($id) {

        $query = DB::connection()->prepare('SELECT * FROM Vastine WHERE keskustelu_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $vastineet = array();

        foreach ($rows as $row) {
            $vastineet[] = new Vastine(array(
                'id' => $row['id'],
                'sisalto' => $row['sisalto'],
                'aika' => $row['aika'],
                'keskustelu_id' => $row['keskustelu_id'],
                'kirjoittaja_id' => $row['kirjoittaja_id']
            ));
        }
        return $vastineet;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Vastine WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $vastine = new Vastine(array(
                'id' => $row['id'],
                'sisalto' => $row['sisalto'],
                'aika' => $row['aika'],
                'keskustelu_id' => $row['keskustelu_id'],
                'kirjoittaja_id' => $row['kirjoittaja_id']
            ));

            return $vastine;
        }

        return null;
    }

    public static function getKirjoittaja($id) {

        $vastine = self::find($id);

        $kid = $vastine->id;

        $query = DB::connection()->prepare('SELECT nimi FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $kid));
        $row = $query->fetch();

        $knimi = $row['nimi'];

        return $knimi;
    }

}
