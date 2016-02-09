<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keskustelu extends BaseModel {

    public $id, $otsikko, $aika, $kirjoittaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Keskustelu');
        $query->execute();
        $rows = $query->fetchAll();
        $keskustelut = array();

        foreach ($rows as $row) {
            $keskustelut[] = new Keskustelu(array(
                'id' => $row['id'],
                'otsikko' => $row['otsikko'],
                'aika' => $row['aika'],
                'kirjoittaja_id' => $row['kirjoittaja_id']
            ));
        }
        return $keskustelut;
    }

}
