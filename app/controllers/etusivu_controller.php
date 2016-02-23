<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EtusivuContoller extends BaseController {
    
    public static function index() {
        
        $options = array();
        $vastineet = Vastine::all();
        $keskustelut = Keskustelu::all($options);
        View::make('etusivu/index.html', array('vastineet' => $vastineet, 'keskustelut' => $keskustelut)); 
    }
    
}