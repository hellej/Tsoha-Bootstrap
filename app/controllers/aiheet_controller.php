<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AiheController extends BaseController {

    public static function index() {
        self::check_logged_in();

        $aiheet = Aihe::all();
        View::make('aihe/index.html', array('aiheet' => $aiheet));
    }

    public static function edit($id) {
        self::check_moderator();

        $aihe = Aihe::find($id);
        View::make('aihe/edit.html', array('aihe' => $aihe));
    }

    public static function show($id) {
        self::check_logged_in();

        $aihe = Aihe::find($id);
        View::make('aihe/esittely.html', array('aihe' => $aihe));
    }

    public static function create() {
        self::check_logged_in();

        View::make('aihe/uusi.html');
    }

    public static function store() {
        self::check_logged_in();

        $params = $_POST;
        
        $aihe = new Aihe(self::getAndSetAttributes($params));
        
        $errors = $aihe->errors();

        if (count($errors) == 0) {
            $aihe->save();
            Redirect::to('/aihelistaus', array('message' => 'Aihe lisätty!'));
        } else {
            Redirect::to('/aihelistaus/uusi', array('errors' => $errors));
        }
    }

    public static function getAndSetAttributes($params) {

        $userid = $_SESSION['user'];

        $attributes = array(
            'nimi' => $params['nimi'],
            'luoja_id' => $userid
        );
        return $attributes;
        
    }

    public static function destroy($id) {
        self::check_moderator();

        $aihe = Aihe::find($id);
        $aihe->destroy();
        Redirect::to('/aihelistaus', array('message' => 'Aihe poistettu!'));
    }

    public static function update($id) {
        self::check_moderator();

        $params = $_POST;
        $vanhaaihe = Aihe::find($id);

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'luontiaika' => $vanhaaihe->luontiaika,
            'luoja_id' => $vanhaaihe->luoja_id
        );

        $aihe = new Aihe($attributes);

        $aihe->update();

        Redirect::to('/aihelistaus/' . $aihe->id, array('message' => 'Aiheen muokkaus onnistui'));
    }

}
