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
        
        
    }

}
