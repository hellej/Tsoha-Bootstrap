<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aihe extends BaseModel {

    public $id, $nimi, $luontiaika, $luoja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Aihe');
        $query->execute();
        $rows = $query->fetchAll();
        $aiheet = array();

        foreach ($rows as $row) {

            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'luoja_id' => $row['luoja_id'],
                'luontiaika' => $row['luontiaika']
            ));
        }

        return $aiheet;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Aihe WHERE id = :id LIMIT 1');
        $query->execute();
        $row = $query->fetch();

        if ($row) {

            $aihe = new Aihe(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'luoja_id' => $row['luoja_id'],
                'luontiaika' => $row['luontiaika']
            ));
            return $aihe;
        }

        return null;
    }

}
