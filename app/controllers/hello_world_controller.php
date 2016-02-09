<?php

class HelloWorldController extends BaseController {

    public static function etusivu() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/etusivu.html');
    }

    public static function foorumietusivu() {
        View::make('suunnitelmat/foorumietusivu.html');
    }

    public static function sandbox() {
        $kayttajat = Kayttaja::all();
        $keskustelut = Keskustelu::all();
        $maija = Kayttaja::find(1);
        Kint::dump($keskustelut);
        Kint::dump($maija);
    }

    public static function aihekuvaus() {
        View::make('suunnitelmat/aihekuvaus.html');
    }

    public static function aihelistaus() {
        View::make('suunnitelmat/aihelistaus.html');
    }

    public static function yaihelistaus() {
        View::make('suunnitelmat/yaihelistaus.html');
    }

    public static function viestilistaus() {
        View::make('suunnitelmat/viestilistaus.html');
    }

    public static function keskustelulistaus() {
        View::make('suunnitelmat/keskustelulistaus.html');
    }

    public static function ykeskustelulistaus() {
        View::make('suunnitelmat/ykeskustelulistaus.html');
    }

    public static function uusikeskustelu() {
        View::make('suunnitelmat/uusikeskustelu.html');
    }

    public static function yetusivu() {
        View::make('suunnitelmat/yetusivu.html');
    }

    public static function ykayttajalistaus() {

        View::make('suunnitelmat/ykayttajalistaus.html');
    }

    public static function kayttajaesittely() {

        View::make('suunnitelmat/kayttajaesittely.html');
    }

    public static function kayttajamuokkaus() {

        View::make('suunnitelmat/kayttajamuokkaus.html');
    }

}
