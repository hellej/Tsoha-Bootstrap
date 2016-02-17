<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RyhmaController extends BaseController {

    public static function index() {

        $ryhmat = Ryhma::all();
        View::make('ryhma/index.html', array('ryhmat' => $ryhmat));
    }

    public static function destroy($id) {

        $ryhma = Ryhma::find($id);

        $ryhma->destroy();

        Redirect::to('/ryhmalistaus', array('message' => 'Ryhmä poistettu onnistuneesti'));
    }

    public static function create() {
        View::make('ryhma/uusi.html');
    }

    public static function store() {
        $params = $_POST;


        if (isset($_SESSION['user'])) {

            $attributes = array(
                'nimi' => $params['nimi'],
                'kuvaus' => $params['kuvaus']
            );

            $ryhma = new Ryhma($attributes);

            $ryhma->save();

            Redirect::to('/ryhmalistaus', array('message' => 'Ryhmä tallennettu'));
            
        } else {

            View::make('ryhma/uusi.html', array('message' => 'Muistithan kirjautua sisään?'));
        }
    }

}
