<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kayttaja extends BaseModel {

    public $id, $ktunnus, $nimi, $sposti, $salasana, $yllapitaja, $kuvaus, $viesteja, $ryhmat;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('validate_nimi', 'validate_ktunnus', 'validate_sposti',
            'validate_salasana');
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

    public function find($id) {

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
                'kuvaus' => $row['kuvaus'],
                'viesteja' => Vastine::getKayttajanVastineidenMaara($id)));

            return $kayttaja;
        }
        return null;
    }


    public static function authenticate($ktunnus, $salasana) {


        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE ktunnus = :ktunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('ktunnus' => $ktunnus, 'salasana' => $salasana));
        $row = $query->fetch();

        if ($row) {
            $user = new Kayttaja(array(
                'id' => $row['id'],
                'ktunnus' => $row['ktunnus'],
                'nimi' => $row['nimi'],
                'sposti' => $row['sposti'],
                'salasana' => $row['salasana'],
                'yllapitaja' => $row['yllapitaja'],
                'kuvaus' => $row['kuvaus']));

            return $user;
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

        foreach ($this->ryhmat as $ryhma) {
            $query = DB::connection()->prepare('INSERT INTO Ryhmakayttaja (ryhma_id, kayttaja_id) Values(:ryhma_id, :kayttaja_id)');
            $query->execute(array('ryhma_id' => $ryhma, 'kayttaja_id' => $this->id));
        }
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Kayttaja SET ktunnus = :ktunnus, nimi= :nimi, sposti = :sposti, salasana = :salasana, kuvaus = :kuvaus, yllapitaja = :yllapitaja WHERE id = :id');

        $query->execute(array('ktunnus' => $this->ktunnus, 'nimi' => $this->nimi,
            'sposti' => $this->sposti, 'salasana' => $this->salasana, 'yllapitaja' => $this->yllapitaja,
            'kuvaus' => $this->kuvaus, 'id' => $this->id
        ));

        $queryresetryhmat = DB::connection()->prepare('DELETE FROM Ryhmakayttaja WHERE kayttaja_id = :kayttaja_id');
        $queryresetryhmat->execute(array('kayttaja_id' => $this->id));

        foreach ($this->ryhmat as $ryhma) {
            $query = DB::connection()->prepare('INSERT INTO Ryhmakayttaja (ryhma_id, kayttaja_id) Values(:ryhma_id, :kayttaja_id)');
            $query->execute(array('ryhma_id' => $ryhma, 'kayttaja_id' => $this->id));
        }
    }

    public function destroy() {

        $queryDone = DB::connection()->prepare('UPDATE Vastine SET kirjoittaja_id = 1 WHERE kirjoittaja_id = :id');
        $queryDone->execute(array('id' => $this->id));
        $queryDtwo = DB::connection()->prepare('UPDATE Keskustelu SET luoja_id = 1 WHERE luoja_id = :id');
        $queryDtwo->execute(array('id' => $this->id));
        $queryDthree = DB::connection()->prepare('UPDATE Aihe SET luoja_id = 1 WHERE luoja_id = :id');
        $queryDthree->execute(array('id' => $this->id));
        $queryDfour = DB::connection()->prepare('UPDATE Ryhmakayttaja SET kayttaja_id = 1 WHERE kayttaja_id = :id');
        $queryDfour->execute(array('id' => $this->id));

        $queryDfive = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
        $queryDfive->execute(array('id' => $this->id));
    }

    public function validate_nimi() {

        return $this->validate_string_length('nimi', $this->nimi, 3);
    }

    public function validate_ktunnus() {

        return $this->validate_string_length('käyttäjätunnus', $this->ktunnus, 3);
    }

    public function validate_sposti() {

        if (strpos($this->sposti, '@') == false) {
            return "sähköpostin pitää sisältää @ merkki";
        }

        return $this->validate_string_length('sähköposti', $this->sposti, 5);
    }

    public function validate_salasana() {

        return $this->validate_string_length('salasana', $this->salasana, 6);
    }

}
