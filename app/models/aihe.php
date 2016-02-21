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

            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'luoja_id' => $row['luoja_id'],
                'luoja_ktunnus' => self::getLuojaKtunnus($row),
                'luontiaika' => $row['luontiaika'],
                'keskustelujen_maara' => Aihe::getKeskustelujenMaara($row['id'])
            ));
        }

        return $aiheet;
    }

    public static function getLuojaKtunnus($row) {

        if ((Kayttaja::find($row['luoja_id'])) != null) {
            return Kayttaja::find($row['luoja_id'])->ktunnus;
        } else {
            return "ylläpito";
        }
    }

    public static function getKeskustelujenMaara($id) {

        $query = DB::connection()->prepare('SELECT COUNT(id) FROM Keskusteluaihe WHERE aihe_id = :aihe_id');
        $query->execute(array('aihe_id' => $id));
        $row = $query->fetch();
        $maara = $row['count'];

        return $maara;
    }

    public static function getKeskustelunAiheet($id) {

        $query = DB::connection()->prepare('SELECT Aihe.nimi FROM Aihe, Keskusteluaihe WHERE Aihe.id = Keskusteluaihe.aihe_id AND Keskusteluaihe.keskustelu_id = :id');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $aiheet = array();

        foreach ($rows as $row) {
            $aiheet[] = $row['nimi'];
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

        $queryDone = DB::connection()->prepare('DELETE FROM Keskusteluaihe WHERE aihe_id = :id');
        $queryDone->execute(array('id' => $this->id));

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
                'luontiaika' => $row['luontiaika'],
                'keskustelujen_maara' => Aihe::getKeskustelujenMaara($row['id'])
            ));

            return $aihe;
        }

        return null;
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Aihe SET nimi = :nimi, luontiaika = :luontiaika, luoja_id = :luoja_id WHERE id = :id');
        $query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'luontiaika' => $this->luontiaika, 'luoja_id' => $this->luoja_id));
    }

    public function validate_nimi() {

        return $this->validate_string_length('nimi', $this->nimi, 2);
    }

}
