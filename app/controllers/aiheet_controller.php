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
       
       
       Redirect::to('/aihelistaus/'. $aihe->id, array('message' => 'Aiheen muokkaus onnistui'));
       
    }

}
