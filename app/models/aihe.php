<?php

class Aihe extends BaseModel {

    public $id, $nimi, $luontiaika, $luoja_id, $luoja_ktunnus, $keskustelujen_maara;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('validate_nimi');
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Aihe');
        $query->execute();
        $rows = $query->fetchAll();
        $aiheet = array();

        foreach ($rows as $row) {

            $aiheet[] = new Aihe(self::getAttributes($row));
        }

        return $aiheet;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT * FROM Aihe WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {

            $aihe = new Aihe(self::getAttributes($row));
            return $aihe;
        }

        return null;
    }

    public static function getAttributes($row) {


        $attributes = array(
            'id' => $row['id'],
            'nimi' => $row['nimi'],
            'luoja_id' => $row['luoja_id'],
            'luoja_ktunnus' => self::getLuojaKtunnus($row),
            'luontiaika' => self::roundTimeStampToDate($row),
            'keskustelujen_maara' => self::getKeskustelujenMaara($row['id']));

        return $attributes;
    }

    public static function getLuojaKtunnus($aihe_id) {

        if ((Kayttaja::find($aihe_id['luoja_id'])) != null) {
            return Kayttaja::find($aihe_id['luoja_id'])->ktunnus;
        } else {
            return "ylläpito";
        }
    }

    public static function getKeskustelujenMaara($aihe_id) {

        $query = DB::connection()->prepare('SELECT COUNT(id) FROM Keskusteluaihe WHERE aihe_id = :aihe_id');
        $query->execute(array('aihe_id' => $aihe_id));
        $row = $query->fetch();
        $maara = $row['count'];

        return $maara;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Aihe (nimi, luontiaika, luoja_id) Values (:nimi, NOW(), :luoja_id) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'luoja_id' => $this->luoja_id));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {

        $queryDone = DB::connection()->prepare('DELETE FROM Keskusteluaihe WHERE aihe_id = :id');
        $queryDone->execute(array('id' => $this->id));

        $query = DB::connection()->prepare('DELETE FROM Aihe WHERE id = :id');
        $query->execute(array('id' => $this->id));
        
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Aihe SET nimi = :nimi, luontiaika = :luontiaika, luoja_id = :luoja_id WHERE id = :id');
        $query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'luontiaika' => $this->luontiaika, 'luoja_id' => $this->luoja_id));
    }

    public static function getKeskustelunAiheet($keskustelu_id) {

        $query = DB::connection()->prepare('SELECT Aihe.nimi FROM Aihe, Keskusteluaihe WHERE Aihe.id = Keskusteluaihe.aihe_id AND Keskusteluaihe.keskustelu_id = :id');
        $query->execute(array('id' => $keskustelu_id));

        $rows = $query->fetchAll();
        $aiheet = array();

        foreach ($rows as $row) {
            $aiheet[] = $row['nimi'];
        }

        return $aiheet;
    }

    public function validate_nimi() {

        return $this->validate_string_length('nimi', $this->nimi, 2);
    }

}
