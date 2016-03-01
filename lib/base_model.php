<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;
    protected $validators_KayttajaUpdate;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona

        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon

            if ($this->{$validator}() != NULL) {
                array_push($errors, $this->{$validator}());
            }
        }

        return $errors;
    }

    public function errorsWhenUpdatingKayttaja() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona

        $errors = array();

        foreach ($this->validators_KayttajaUpdate as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon

            if ($this->{$validator}() != NULL) {
                array_push($errors, $this->{$validator}());
            }
        }

        return $errors;
    }

    public function roundTimeStampToTime($row) {

        $rawtime = $row['aika'];
        $timestamp = strtotime($rawtime);
        return date("j.n.Y G.i", $timestamp);
    }

    public function roundTimeStampToDate($row) {

        $rawtime = $row['luontiaika'];
        $timestamp = strtotime($rawtime);
        return date("j.n.Y", $timestamp);
    }

    public function validate_string_length($attribute, $string, $length) {

        $error = "";

        if ($string == '' || $string == null) {
            $error = $attribute . ' ei voi olla tyhjä!';
        } else if (strlen($string) <= $length) {
            $error = $attribute . ' on oltava pidempi kuin ' . $length . ' merkkiä !';
        }

        return $error;
    }

}
