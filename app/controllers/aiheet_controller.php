<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AiheController extends BaseController {

    public static function index() {

        $aiheet = Aihe::all();
        View::make('aihe/index.html', array('aiheet' => $aiheet));
    }

    public static function edit($id) {

        $aihe = Aihe::find($id);

        View::make('aihe/edit.html', array('aihe' => $aihe));
    }

    public static function show($id) {

        $aihe = Aihe::find($id);
        View::make('aihe/esittely.html', array('aihe' => $aihe));
    }

    public static function create() {

        View::make('aihe/uusi.html');
    }

    public static function store() {

        $params = $_POST;

        if (isset($_SESSION['user'])) {

            $userid = $_SESSION['user'];


            $attributes = array(
                'nimi' => $params['nimi'],
                'luoja_id' => $userid
            );

//            Kint::dump($aihe);

            $aihe = new Aihe($attributes);
            $aihe->save();

//            Kint::dump($aihe);

            Redirect::to('/aihelistaus', array('message' => 'Aihe lisätty!'));
        } else {

            View::make('aihe/uusi.html', array('message' => 'Muistithan kirjautua sisään?'));
        }
    }

    public static function destroy($id) {

        $aihe = Aihe::find($id);
        $aihe->destroy();
        Redirect::to('/aihelistaus', array('message' => 'Aihe poistettu!'));
    }

    public static function update($id) {

        $params = $_POST;
        $vanhaaihe = Aihe::find($id);

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'luontiaika' => $vanhaaihe->luontiaika,
            'luoja_id' => $vanhaaihe->luoja_id
        );

        $aihe = new Aihe($attributes);

        Kint::dump($aihe);

        $aihe->update();


        Redirect::to('/aihelistaus/' . $aihe->id, array('message' => 'Aiheen muokkaus onnistui'));
    }

}
