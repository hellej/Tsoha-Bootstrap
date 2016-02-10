<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kayttaja extends BaseModel {

    public $id, $ktunnus, $nimi, $sposti, $salasana, $yllapitaja, $kuvaus;

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
                'yllapitaja' => $row['yllapitaja'],
                'kuvaus' => $row['kuvaus']));
        }

        return $kayttajat;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'ktunnus' => $row['ktunnus'],
                'nimi' => $row['nimi'],
                'sposti' => $row['sposti'],
                'salasana' => $row['salasana'],
                'yllapitaja' => $row['yllapitaja'],
                'kuvaus' => $row['kuvaus']));

            return $kayttaja;
        }
        return null;
    }

    public function save(){
        
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, kuvaus) VALUES (:ktunnus, :nimi, :sposti, :salasana, :kuvaus) RETURNING id');
        
        $query->execute(array('ktunnus' => $this->ktunnus, 'nimi' => $this->nimi,
            'sposti' => $this->sposti, 'salasana' => $this->salasana,
            'kuvaus' => $this->kuvaus
            ));

        
        $row = $query->fetch();
        
        $this->id = $row['id'];
        
    }
    
    
}
