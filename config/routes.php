<?php

$routes->get('/foorumi', function() {
    EtusivuContoller::index();
});



$routes->get('/kayttajalistaus/:id/edit', function($id) {
    KayttajaController::edit($id);
});
$routes->post('/kayttajalistaus/:id/edit', function($id) {
    KayttajaController::update($id);
});
$routes->post('/kayttajalistaus/:id/destroy', function($id) {
    KayttajaController::destroy($id);
});
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


$routes->post('/aihe', function() {
    AiheController::store();
});
$routes->get('/aihelistaus/uusi', function() {
    AiheController::create();
});
$routes->get('/aihelistaus/:id', function($id) {
    AiheController::show($id);
});
$routes->get('/aihelistaus', function() {
    AiheController::index();
});
$routes->get('/aihelistaus/:id/edit', function($id) {
    AiheController::edit($id);
});
$routes->post('/aihelistaus/:id/edit', function($id) {
    AiheController::update($id);
});
$routes->post('/aihelistaus/:id/destroy', function($id) {
    AiheController::destroy($id);
});


$routes->get('/ryhmalistaus', function() {
    RyhmaController::index();
});
$routes->post('/ryhmalistaus/:id/destroy', function($id) {
    RyhmaController::destroy($id);
});
$routes->get('/ryhmalistaus/uusi', function() {
    RyhmaController::create();
});
$routes->post('/ryhma', function() {
    RyhmaController::store();
});


$routes->post('/keskustelu/haku', function() {
    KeskusteluController::index();
});
$routes->post('/keskustelu', function() {
    KeskusteluController::store();
});
$routes->get('/keskustelulistaus', function() {
    KeskusteluController::index();
});
$routes->get('/keskustelulistaus/uusi', function() {
    KeskusteluController::create();
});
$routes->get('/keskustelulistaus/:id/edit', function($id) {
    KeskusteluController::edit($id);
});
$routes->post('/keskustelulistaus/:id/edit', function($id) {
    KeskusteluController::update($id);
});
$routes->get('/keskustelulistaus/:id/destroy', function($id) {
    KeskusteluController::destroy($id);
});


$routes->get('/keskustelulistaus/:id', function($id) {
    VastineController::indexKeskustelunVastineet($id);
});
$routes->post('/keskustelulistaus/:id', function($id) {
    VastineController::store($id);
});




$routes->get('/logout', function() {
    KayttajaController::logout();
});
$routes->get('/login', function() {
    KayttajaController::login();
});
$routes->post('/login', function() {
    KayttajaController::handle_login();
});




$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
