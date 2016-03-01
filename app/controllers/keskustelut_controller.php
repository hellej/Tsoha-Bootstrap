<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KeskusteluController extends BaseController {

    public static function index() {
        self::check_logged_in();

        $params = $_POST;

//KATSOTAAN MITÄ HAKUSANOJA SAATIIN JOS SAATIIN:
        $options = self::readSearchTerms($params);

        $keskustelut = Keskustelu::all($options);
        View::make('keskustelu/index.html', array('keskustelut' => $keskustelut, 'options' => $options));
    }

    public static function readSearchTerms($params) {

        $options = array();

        if (isset($params['search_ktunnus'])) {
            $search_ktunnus = $params['search_ktunnus'];
            if (strlen($search_ktunnus) > 1) {
                $options['search_ktunnus'] = $params['search_ktunnus'];
            }
        }

        if (isset($params['search_aihe'])) {
            $search_aihe = $params['search_aihe'];
            if (strlen($search_aihe) > 1) {
                $options['search_aihe'] = $params['search_aihe'];
            }
        }

        return $options;
        
    }

    public static function create() {
        self::check_logged_in();

        $aiheet = Aihe::all();
        View::make('keskustelu/uusi.html', array('aiheet' => $aiheet));
        
    }

    public static function store() {
        self::check_logged_in();

        $params = $_POST;

        $keskustelu = new Keskustelu(self::setAndGetAttributes($params));

        $errors = $keskustelu->errors();

        if (count($errors) == 0) {
            $keskustelu->save();
            Redirect::to('/keskustelulistaus/' . $keskustelu->id, array('message' => 'Onnistui!'));
        } else {
            Redirect::to('/keskustelulistaus/uusi', array('errors' => $errors));
        }
    }

    public static function setAndGetAttributes($params) {

        $userid = $_SESSION['user'];
        $user = Kayttaja::find($userid);
        $userktunnus = $user->ktunnus;

        $attributes = array(
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'luoja_id' => $userid,
            'luoja_ktunnus' => $userktunnus,
            'aiheet' => array()
        );

        $attributes = self::getAndSetAiheet($params, $attributes);

        return $attributes;
    }

    public static function getAndSetAiheet($params, $attributes) {

        if (isset($params['aiheet'])) {
            $aiheet = $params['aiheet'];
            foreach ($aiheet as $aihe) {
                $attributes['aiheet'][] = $aihe;
            }
        }

        return $attributes;
    }

}
