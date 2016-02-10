<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KayttajaController extends BaseController {

    public static function index() {

        $kayttajat = Kayttaja::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function show($id) {

        $kayttaja = Kayttaja::find($id);

        View::make('kayttaja/esittely.html', array('kayttaja' => $kayttaja));
    }

    public static function store() {

        $params = $_POST;

        $kayttaja = new Kayttaja(array(
            'ktunnus' => $params['ktunnus'],
            'nimi' => $params['nimi'],
            'sposti' => $params['sposti'],
            'salasana' => $params['salasana'],
            'kuvaus' => $params['kuvaus']));

        $kayttaja->save();

        Redirect::to('/kayttajalistaus/' . $kayttaja->id, array('message' => 'Käyttäjätiedot tallennettu!'));
    }

    public static function create() {

        View::make('kayttaja/uusi.html');
    }

}
