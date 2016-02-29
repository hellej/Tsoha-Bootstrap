<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VastineController extends BaseController {

    public static function indexKeskustelunVastineet($keskustelu_id) {
        self::check_logged_in();
        
//        KESKUSTELUN ID

        $vastineet = Vastine::allKeskustelu($keskustelu_id);
        $keskustelu = Keskustelu::find($keskustelu_id);

        View::make('vastine/index.html', array('vastineet' => $vastineet, 'keskustelu' => $keskustelu, 'aiheet' => $keskustelu->aiheet));
    }

    public static function store($keskustelu_id) {
        self::check_logged_in();

        $params = $_POST;
        $userid = $_SESSION['user'];

        $attributes = array(
            'sisalto' => $params['sisalto'],
            'keskustelu_id' => $keskustelu_id,
            'kirjoittaja_id' => $userid
        );

        $vastine = new Vastine($attributes);

        $errors = $vastine->errors();

        if ((count($errors)) == 0) {
            $vastine->save();
            Redirect::to('/keskustelulistaus/' . $vastine->keskustelu_id, array('message' => 'Viesti tallennettu!'));
        } else {

            Redirect::to('/keskustelulistaus/' . $vastine->keskustelu_id, array('errors' => $errors));
        }
    }

}
