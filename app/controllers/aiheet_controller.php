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
    
    
}