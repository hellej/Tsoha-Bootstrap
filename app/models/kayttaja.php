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

        $this->validators = array('validate_ktunnus', 'validate_nimi', 'validate_sposti',
            'validate_salasana', 'validate_yllapitaja');
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

    public static function authenticate($ktunnus, $salasana) {


        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE ktunnus = :ktunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('ktunnus' => $ktunnus, 'salasana' => $salasana));
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

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Kayttaja (ktunnus, nimi, sposti, salasana, kuvaus, yllapitaja) VALUES (:ktunnus, :nimi, :sposti, :salasana, :kuvaus, :yllapitaja) RETURNING id');

        $query->execute(array('ktunnus' => $this->ktunnus, 'nimi' => $this->nimi,
            'sposti' => $this->sposti, 'salasana' => $this->salasana, 'yllapitaja' => $this->yllapitaja,
            'kuvaus' => $this->kuvaus
        ));


        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Kayttaja SET ktunnus = :ktunnus, nimi= :nimi, sposti = :sposti, salasana = :salasana, kuvaus = :kuvaus, yllapitaja = :yllapitaja WHERE id = :id');

        $query->execute(array('ktunnus' => $this->ktunnus, 'nimi' => $this->nimi,
            'sposti' => $this->sposti, 'salasana' => $this->salasana, 'yllapitaja' => $this->yllapitaja,
            'kuvaus' => $this->kuvaus, 'id' => $this->id
        ));

        $row = $query->fetch();
//        $this->id = $row['id'];
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_ktunnus() {

        return $this->validate_string_length($this->ktunnus, 5);
    }

    public function validate_nimi() {

        return $this->validate_string_length($this->nimi, 3);
    }

    public function validate_sposti() {

        return $this->validate_string_length($this->sposti, 5);
    }

    public function validate_salasana() {

        return $this->validate_string_length($this->salasana, 5);
    }

    public function validate_yllapitaja() {

        if ($this->yllapitaja != 'joo' && $this->yllapitaja != 'ei') {
            return 'joo tai ei pitäis olla';
        }
    }

}
