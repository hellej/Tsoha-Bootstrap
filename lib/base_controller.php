<?php

class BaseController {

    public static function get_user_logged_in() {

        if (isset($_SESSION['user'])) {
            $kayttaja_id = $_SESSION['user'];

            $kayttaja = Kayttaja::find($kayttaja_id);
            return $kayttaja;
        }

        return null;
    }
    
    public static function get_user_moderator() {
        
        $user = self::get_user_logged_in();
        return $user->yllapitaja;
       
    }
    

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('error' => 'kirjautuminen vaaditaan !'));
        }
    }

    public static function check_moderator() {

        self::check_logged_in();

        $userid = $_SESSION['user'];
        $user = Kayttaja::find($userid);

        if (!$user->yllapitaja) {
            Redirect::to('/foorumi', array('error' => 'Ylläpitäjyys vaaditaan !'));
        }
    }

    public static function editingMeOrBeingModerator($id) {

        self::check_logged_in();

        $userid = $_SESSION['user'];
        $user = Kayttaja::find($userid);

        if ($userid != $id && !$user->yllapitaja) {
            Redirect::to('/kayttajalistaus', array('error' => 'Vain ylläpito voi muokata muiden käyttäjien tietoja !'));
        }
    }

}
