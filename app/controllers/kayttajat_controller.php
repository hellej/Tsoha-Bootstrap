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
        session_unset();

        Redirect::to('/login', array('message' => 'Uloskirjautuminen onnistui!'));
    }

    public static function handle_login() {

        $params = $_POST;

        Kint::dump($params);

        $user = Kayttaja::authenticate($params['ktunnus'], $params['salasana']);



        if (!$user) {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana',
                'ktunnus' => $params['ktunnus']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/foorumi', array('message' => 'Tervetuloa takaisin ' . $user->ktunnus . '!'));
        }
//        
    }

    public static function index() {

        $kayttajat = Kayttaja::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function show($id) {

        $kayttaja = Kayttaja::find($id);
        View::make('kayttaja/esittely.html', array('kayttaja' => $kayttaja));
    }

    public static function edit($id) {

        $kayttaja = Kayttaja::find($id);

        View::make('kayttaja/edit.html', array('kayttaja' => $kayttaja));
    }

    public static function destroy($id) {

        $params = $_POST;

        $attributes = array(
            'id' => $id);

        $kayttaja = new Kayttaja($attributes);

        $kayttaja->destroy();

        Redirect::to('/kayttajalistaus', array('message' => 'Käyttäjä poistettu onnistuneesti'));
    }

    public static function update($id) {

        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'ktunnus' => $params['ktunnus'],
            'nimi' => $params['nimi'],
            'sposti' => $params['sposti'],
            'salasana' => $params['salasana'],
            'yllapitaja' => $params['yllapitaja'],
            'kuvaus' => $params['kuvaus']);

        $kayttaja = new Kayttaja($attributes);

        $errors = $kayttaja->errors();


        if (count($errors) > 0) {
            View::make('kayttaja/edit.html', array('errors' => $errors, 'kayttaja' => $attributes));
        } else {
            $kayttaja->update();
            Redirect::to('/kayttajalistaus/' . $kayttaja->id, array('message' => 'Käyttäjäteidot muokattu onnistuneesti!'));
        }
    }

    public static function store() {

        $params = $_POST;

        $attributes = array(
            'ktunnus' => $params['ktunnus'],
            'nimi' => $params['nimi'],
            'sposti' => $params['sposti'],
            'salasana' => $params['salasana'],
            'yllapitaja' => $params['yllapitaja'],
            'kuvaus' => $params['kuvaus']);

        $kayttaja = new Kayttaja($attributes);

        Kint::dump($kayttaja);

        $errors = $kayttaja->errors();

        if (count($errors) == 0) {
            $kayttaja->save();
            Redirect::to('/kayttajalistaus/' . $kayttaja->id, array('message' => 'Käyttäjätiedot tallennettu!'));
        } else {
            View::make('kayttaja/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {

        View::make('kayttaja/uusi.html');
    }

}
