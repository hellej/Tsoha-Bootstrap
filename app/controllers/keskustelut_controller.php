<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KeskusteluController extends BaseController {

    public static function index() {
        
        $keskustelut = Keskustelu::all(); 
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('keskustelu/index.html', array('keskustelut' => $keskustelut));
    }

}
