<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keskustelu extends BaseModel {

    public $id, $otsikko, $sisalto, $aika, $kirjoittaja_id, $kirjoittaja_ktunnus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.kirjoittaja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja WHERE Keskustelu.kirjoittaja_id = Kayttaja.id');
        $query->execute();
        $rows = $query->fetchAll();
        $keskustelut = array();

        foreach ($rows as $row) {
            $keskustelut[] = new Keskustelu(array(
                'id' => $row['id'],
                'otsikko' => $row['otsikko'],
                'sisalto' => $row['sisalto'],
                'aika' => $row['aika'],
                'kirjoittaja_id' => $row['kirjoittaja_id'],
                'kirjoittaja_ktunnus' => $row['ktunnus']
            ));
        }
        return $keskustelut;
    }

    
    
    public static function find($id) {

        $query = DB::connection()->prepare('SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.kirjoittaja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja WHERE Keskustelu.kirjoittaja_id = Kayttaja.id AND Keskustelu.id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $keskustelu = new Keskustelu(array(
                'id' => $row['id'],
                'otsikko' => $row['otsikko'],
                'sisalto' => $row['sisalto'],
                'aika' => $row['aika'],
                'kirjoittaja_id' => $row['kirjoittaja_id'],
                'kirjoittaja_ktunnus' => $row['ktunnus']
            ));

            return $keskustelu;
        }

        return null;
    }
    
    public static function getKirjoittaja($id) {
        
        $keskustelu = self::find($id);
        
        $kid = $keskustelu->id;
        
        $query = DB::connection()->prepare('SELECT nimi FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $kid));
        $row = $query->fetch();
        
        $knimi = $row['nimi'];
            
        return $knimi;
        
    }

}
