<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VastineController extends BaseController {

    public static function index($id) {
        self::check_logged_in();
        
//        KESKUSTELUN ID

        $vastineet = Vastine::allKeskustelu($id);
        $keskustelu = Keskustelu::find($id);
        $aiheet = Aihe::getKeskustelunAiheet($id);

        View::make('vastine/index.html', array('vastineet' => $vastineet, 'keskustelu' => $keskustelu, 'aiheet' => $aiheet));
    }

    public static function store($id) {
        self::check_logged_in();

        $params = $_POST;
        $userid = $_SESSION['user'];

        $attributes = array(
            'sisalto' => $params['sisalto'],
            'keskustelu_id' => $id,
            'kirjoittaja_id' => $userid
        );

        $vastine = new Vastine($attributes);

        $errors = $vastine->errors();

        if ((count($errors)) == 0) {
            $vastine->save();
            Redirect::to('/vastinelistaus/' . $vastine->keskustelu_id, array('message' => 'Viesti tallennettu!'));
        } else {

            Redirect::to('/vastinelistaus/' . $vastine->keskustelu_id, array('errors' => $errors));
        }
    }

}
