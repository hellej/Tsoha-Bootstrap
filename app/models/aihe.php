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

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Aihe (nimi, luontiaika, luoja_id) Values (:nimi, NOW(), :luoja_id) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'luoja_id' => $this->luoja_id));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Aihe WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Aihe WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
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

    public function update() {

        $query = DB::connection()->prepare('UPDATE Aihe SET nimi = :nimi, luontiaika = :luontiaika, luoja_id = :luoja_id WHERE id = :id');
        $query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'luontiaika' => $this->luontiaika, 'luoja_id' => $this->luoja_id));
    }

}
