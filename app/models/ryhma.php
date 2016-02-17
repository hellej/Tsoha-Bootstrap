<?php

class Ryhma extends BaseModel {

    public $id, $nimi, $kuvaus, $luontiaika;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Ryhma');
        $query->execute();
        $rows = $query->fetchAll();
        $ryhmat = array();

        foreach ($rows as $row) {

            $ryhmat[] = new Ryhma(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'luontiaika' => $row['luontiaika']
            ));
        }

        return $ryhmat;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Ryhma WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {

            $ryhma = new Ryhma(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'luontiaika' => $row['luontiaika']
            ));
            return $ryhma;
        }

        return null;
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM Ryhma WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Ryhma (nimi, kuvaus, luontiaika) Values (:nimi, :kuvaus, NOW()) RETURNING ID');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));

        $row = $query->fetch();
        $this->id = $row['id'];
        
    }

}
