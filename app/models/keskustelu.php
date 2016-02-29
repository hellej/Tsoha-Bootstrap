<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keskustelu extends BaseModel {

    public $id, $otsikko, $sisalto, $aika, $luoja_id, $luoja_ktunnus, $viestienmaara, $aiheet;

    public function __construct($attributes) {
        
        parent::__construct($attributes);

        $this->validators = array('validate_otsikko', 'validate_sisalto');
    }

    public static function all($options) {

        $query = self::makeSearchOrAllQuery($options);
        $rows = $query->fetchAll();

        $keskustelut = array();

        foreach ($rows as $row) {
            $keskustelut[] = new Keskustelu(self::getAttributes($row));
        }

        return $keskustelut;
    }

    public static function find($id) {

        $query = DB::connection()->prepare('SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.luoja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja WHERE Keskustelu.luoja_id = Kayttaja.id AND Keskustelu.id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $keskustelu = new Keskustelu(self::getAttributes($row));
            return $keskustelu;
        }

        return null;
    }

    public static function getAttributes($row) {

        $attributes = array(
            'id' => $row['id'],
            'otsikko' => $row['otsikko'],
            'sisalto' => $row['sisalto'],
            'aika' => $row['aika'],
            'luoja_id' => $row['luoja_id'],
            'luoja_ktunnus' => $row['ktunnus'],
            'viestienmaara' => Vastine::getKeskustelunVastineidenMaara($row['id']),
            'aiheet' => Aihe::getKeskustelunAiheet($row['id'])
        );

        return $attributes;
    }

    public static function makeSearchOrAllQuery($options) {

        if (isset($options['search_ktunnus'])) {
            $search_query = ' AND Kayttaja.ktunnus LIKE :like ORDER BY Keskustelu.aika DESC';
            $search_word = '%' . $options['search_ktunnus'] . '%';
            $search_type = "ktunnus";
        } else if (isset($options['search_aihe'])) {
            $search_query = ' AND Aihe.nimi LIKE :like ORDER BY Keskustelu.aika DESC';
            $search_word = '%' . $options['search_aihe'] . '%';
            $search_type = "aihe";
        }

        if (isset($search_query)) {
            $query = self::formExecuteAndReturnSearchQuery($search_query, $search_word, $search_type);
        } else {
            $query = self::formExecuteAndReturnAllQuery();
        }

        return $query;
    }

    public static function formExecuteAndReturnSearchQuery($search_query, $search_word, $search_type) {

        if ($search_type == "aihe") {
            $query_string = 'SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.luoja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja, Keskusteluaihe, Aihe '
                    . 'WHERE Keskustelu.luoja_id = Kayttaja.id AND Keskustelu.id = Keskusteluaihe.keskustelu_id AND Keskusteluaihe.aihe_id = Aihe.id';
        } else if ($search_type == "ktunnus") {
            $query_string = 'SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.luoja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja '
                    . 'WHERE Keskustelu.luoja_id = Kayttaja.id ';
        }

        $query_string .= $search_query;
        $query = DB::connection()->prepare($query_string);

        $search_ktunnus = array('like' => $search_word);
        $query->execute($search_ktunnus);

        return $query;
    }

    public static function formExecuteAndReturnAllQuery() {
        $query_string = 'SELECT Keskustelu.id, Keskustelu.otsikko, Keskustelu.sisalto, Keskustelu.aika, Keskustelu.luoja_id, Kayttaja.ktunnus FROM Keskustelu, Kayttaja WHERE Keskustelu.luoja_id = Kayttaja.id ORDER BY Keskustelu.aika DESC';
        $query = DB::connection()->prepare($query_string);
        $query->execute();
        return $query;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Keskustelu (otsikko, sisalto, aika, luoja_id)  Values(:otsikko, :sisalto, NOW(), :luoja_id) RETURNING id');
        $query->execute(array('otsikko' => $this->otsikko, 'sisalto' => $this->sisalto, 'luoja_id' => $this->luoja_id));

        $row = $query->fetch();
        $this->id = $row['id'];

        foreach ($this->aiheet as $aihe) {
            $query = DB::connection()->prepare('INSERT INTO Keskusteluaihe (aihe_id, keskustelu_id) Values(:aihe_id, :keskustelu_id)');
            $query->execute(array('aihe_id' => $aihe, 'keskustelu_id' => $this->id));
        }
    }


    public function validate_otsikko() {

        return $this->validate_string_length('otsikko', $this->otsikko, 3);
    }

    public function validate_sisalto() {

        return $this->validate_string_length('sisältö', $this->sisalto, 3);
    }
    

}
