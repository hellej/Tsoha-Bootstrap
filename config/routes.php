<?php

$routes->get('/', function() {
    HelloWorldController::etusivu();
});

$routes->get('/foorumi', function() {
    HelloWorldController::foorumietusivu();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/aihekuvaus', function() {
    HelloWorldController::aihekuvaus();
});

$routes->get('/aihelistaus', function() {
    AiheController::index();
});

$routes->get('/yaihelistaus', function() {
    HelloWorldController::yaihelistaus();
});

$routes->get('/viestilistaus', function() {
    HelloWorldController::viestilistaus();
});

$routes->get('/keskustelulistaus', function() {
    KeskusteluController::index();
});

$routes->get('/ykeskustelulistaus', function() {
    HelloWorldController::ykeskustelulistaus();
});

$routes->get('/uusikeskustelu', function() {
    HelloWorldController::uusikeskustelu();
});

$routes->get('/yetusivu', function() {
    HelloWorldController::yetusivu();
});

$routes->get('/ykayttajalistaus', function() {
    HelloWorldController::ykayttajalistaus();
});

$routes->get('/kayttajalistaus', function() {
    KayttajaController::index();
});

$routes->get('/kayttajaesittely', function() {
    HelloWorldController::kayttajaesittely();
});

$routes->get('/kayttajamuokkaus', function() {
    HelloWorldController::kayttajamuokkaus();
});