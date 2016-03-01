<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KayttajaController extends BaseController {

    public static function login() {

        View::make('kayttaja/login.html');
    }

    public static function logout() {

        $_SESSION['user'] = null;
        session_unset();
        Redirect::to('/login', array('message' => 'Uloskirjautuminen onnistui!'));
    }

    public static function handle_login() {

        $params = $_POST;

        $user = Kayttaja::authenticate($params['ktunnus'], $params['salasana']);

        if (!$user) {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana',
                'ktunnus' => $params['ktunnus']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/foorumi', array('message' => 'Tervetuloa takaisin ' . $user->ktunnus . '!'));
        }
    }

    public static function index() {
        self::check_logged_in();

        $kayttajat = Kayttaja::all();
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function show($id) {
        self::check_logged_in();

        $kayttaja = Kayttaja::find($id);
        $ryhmat = Ryhma::getKayttajanRyhmat($id);
        View::make('kayttaja/esittely.html', array('kayttaja' => $kayttaja, 'ryhmat' => $ryhmat));
    }

    public static function edit($id) {
        self::editingMeOrBeingModerator($id);

        $ryhmat = Ryhma::all();
        $kayttaja = Kayttaja::find($id);

        View::make('kayttaja/edit.html', array('kayttaja' => $kayttaja, 'ryhmat' => $ryhmat));
    }

    public static function destroy($id) {

        self::editingMeOrBeingModerator($id);

        $params = $_POST;

        $attributes = array(
            'id' => $id);

        $kayttaja = new Kayttaja($attributes);
        $kayttaja->destroy();

        Redirect::to('/kayttajalistaus', array('message' => 'Käyttäjä poistettu onnistuneesti'));
    }

    public static function create() {

        $ryhmat = Ryhma::all();
        View::make('kayttaja/uusi.html', array('ryhmat' => $ryhmat));
    }

    public static function update($id) {

        $params = $_POST;

        $kayttaja = new Kayttaja(self::setAndGetAttributes($params));
        $kayttaja->id = $id;

        $errors = $kayttaja->errorsWhenUpdatingKayttaja();

        if (count($errors) > 0) {
            View::make('kayttaja/edit.html', array('errors' => $errors, 'kayttaja' => $kayttaja));
        } else {
            $kayttaja->update();
            Redirect::to('/kayttajalistaus/' . $kayttaja->id, array('message' => 'Käyttäjätiedot muokattu onnistuneesti!'));
        }
    }

    public static function store() {

        $params = $_POST;

        $attributes = self::setAndGetAttributes($params);
        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (count($errors) == 0) {
            $kayttaja->save();
            Redirect::to('/login', array('message' => 'Käyttäjätiedot tallennettu, voit nyt kirjautua sisään!'));
        } else {
            $ryhmat = Ryhma::all();
            View::make('kayttaja/uusi.html', array('errors' => $errors, 'attributes' => $attributes, 'ryhmat' => $ryhmat));
        }
    }

    public static function setAndGetAttributes($params) {

        $yllapitaja = self::userIsModerator($params);
        
        $ktunnus = trim($params['ktunnus']," ");

        $ownattributes = array(
            'ktunnus' => $ktunnus,
            'nimi' => $params['nimi'],
            'sposti' => $params['sposti'],
            'salasana' => $params['salasana'],
            'yllapitaja' => $yllapitaja,
            'kuvaus' => $params['kuvaus'],
            'ryhmat' => array());

        $attributes = self::getAndSetRyhmat($params, $ownattributes);

        return $attributes;
    }

    public static function getAndSetRyhmat($params, $attributes) {

        if (isset($params['ryhmat'])) {
            $ryhmat = $params['ryhmat'];
            foreach ($ryhmat as $ryhma) {
                $attributes['ryhmat'][] = $ryhma;
            }
        }
        return $attributes;
    }

    public static function userIsModerator($params) {

        if (isset($params['yllapitaja'])) {
            $yllapitaja = 'TRUE';
        } else {
            $yllapitaja = 'FALSE';
        }
        return $yllapitaja;
    }

}