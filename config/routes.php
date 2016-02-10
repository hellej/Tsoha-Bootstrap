<?php



$routes->get('/kayttajalistaus', function() {
    KayttajaController::index();
});

$routes->post('/kayttaja', function() {
    KayttajaController::store();
});

$routes->get('/kayttajalistaus/uusi', function() {
    KayttajaController::create();
});

$routes->get('/kayttajalistaus/:id', function($id) {
    KayttajaController::show($id);
});



$routes->get('/aihelistaus', function() {
    AiheController::index();
});



$routes->get('/keskustelulistaus', function() {
    KeskusteluController::index();
});



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

$routes->get('/yaihelistaus', function() {
    HelloWorldController::yaihelistaus();
});

$routes->get('/viestilistaus', function() {
    HelloWorldController::viestilistaus();
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

$routes->get('/kayttajaesittely', function() {
    HelloWorldController::kayttajaesittely();
});

$routes->get('/kayttajamuokkaus', function() {
    HelloWorldController::kayttajamuokkaus();
});





