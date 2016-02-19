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

    public static function create() {


        View::make('keskustelu/uusi.html');
    }

    public static function store() {

//        View::make('keskustelu/index.html');

        
        $params = $_POST;
        
        Kint::dump($params);
        $userid = $_SESSION['user'];
        Kint::dump($userid);

        if (isset($_SESSION['user'])) {
            $userid = $_SESSION['user'];
            $user = Kayttaja::find($userid);
            $userktunnus = $user->ktunnus;


            $attributes = array(
                'otsikko' => $params['otsikko'],
                'sisalto' => $params['sisalto'],
                'luoja_id' => $userid,
                'luoja_ktunnus' => $userktunnus
            );

            $keskustelu = new Keskustelu($attributes);
            
            
            Kint::dump($keskustelu);
            
            $keskustelu->save();

            Redirect::to('/vastinelistaus/' . $keskustelu->id, array('message' => 'Onnistui!'));
            
        } else {
            
        }
    }

}
