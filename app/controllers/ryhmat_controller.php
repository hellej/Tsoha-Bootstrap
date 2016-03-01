<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RyhmaController extends BaseController {

    public static function index() {
        self::check_logged_in();

        $ryhmat = Ryhma::all();
        View::make('ryhma/index.html', array('ryhmat' => $ryhmat));
        
    }

    public static function destroy($id) {
        self::check_moderator();

        $ryhma = Ryhma::find($id);
        $ryhma->destroy();

        Redirect::to('/ryhmalistaus', array('message' => 'Ryhmä poistettu onnistuneesti'));
        
    }

    public static function create() {
        self::check_moderator();

        View::make('ryhma/uusi.html');
        
    }

    public static function store() {
        self::check_logged_in();

        $params = $_POST;
        
        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );

        $ryhma = new Ryhma($attributes);

        $errors = $ryhma->errors();

        if (count($errors) == 0) {
            $ryhma->save();
            Redirect::to('/ryhmalistaus', array('message' => 'Ryhmä tallennettu'));
        } else {
            View::make('ryhma/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
        
    }

}
