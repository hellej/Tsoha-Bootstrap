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
    HelloWorldController::aihelistaus();
});

$routes->get('/yaihelistaus', function() {
    HelloWorldController::yaihelistaus();
});

$routes->get('/viestilistaus', function() {
    HelloWorldController::viestilistaus();
});

$routes->get('/keskustelulistaus', function() {
    HelloWorldController::keskustelulistaus();
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