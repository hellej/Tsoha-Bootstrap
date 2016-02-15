<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VastineController extends BaseController {
    
    
    
    
    public static function index($id) {
//        KESKUSTELUN ID
        
        
        $vastineet = Vastine::allKeskustelu($id);
        $keskustelu = Keskustelu::find($id);
        
        View::make('vastine/index.html', array('vastineet' => $vastineet, 'keskustelu' => $keskustelu));
        
    }
    

    
}