<?php

class Ryhma extends BaseModel {

    public $id, $nimi, $kuvaus, $luontiaika;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('validate_nimi', 'validate_kuvaus');
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Ryhma');
        $query->execute();
        $rows = $query->fetchAll();
        $ryhmat = array();

        foreach ($rows as $row) {
            $ryhmat[] = new Ryhma(self::getAttributes($row));
        }

        return $ryhmat;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Ryhma WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $ryhma = new Ryhma(self::getAttributes($row));
            return $ryhma;
        }

        return null;
    }

    public static function getAttributes($row) {

        $attributes = array(
            'id' => $row['id'],
            'nimi' => $row['nimi'],
            'kuvaus' => $row['kuvaus'],
            'luontiaika' => $row['luontiaika']
        );

        return $attributes;
    }

    public function getKayttajanRyhmat($kayttaja_id) {

        $query = DB::connection()->prepare('SELECT Ryhma.nimi FROM Ryhma, Ryhmakayttaja WHERE :id = Ryhmakayttaja.kayttaja_id AND Ryhmakayttaja.ryhma_id = Ryhma.id');
        $query->execute(array('id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $ryhmat = array();

        foreach ($rows as $row) {
            $ryhmat[] = $row['nimi'];
        }

        return $ryhmat;
    }

    public function destroy() {

        $queryDone = DB::connection()->prepare('DELETE FROM Ryhmakayttaja WHERE ryhma_id = :id');
        $queryDone->execute(array('id' => $this->id));

        $query = DB::connection()->prepare('DELETE FROM Ryhma WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Ryhma (nimi, kuvaus, luontiaika) Values (:nimi, :kuvaus, NOW()) RETURNING ID');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validate_nimi() {

        return $this->validate_string_length('nimi', $this->nimi, 1);
    }

    public function validate_kuvaus() {

        return $this->validate_string_length('kuvaus', $this->kuvaus, 2);
    }

}
