<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/

/**
 * Country Routes
 */
$router->get('/countries', 'CountriesController@index');
$router->post('/countries', 'CountriesController@store');
$router->get('/countries/{countryId}', 'CountriesController@show');
$router->put('/countries/{countryId}', 'CountriesController@update');

/**
 * State Routes
 */
$router->get('/states', 'StatesController@index');
$router->post('/states', 'StatesController@store');
$router->get('/states/{stateId}', 'StatesController@show');
$router->put('/states/{stateId}', 'StatesController@update');

/**
 * County Routes
 */
$router->get('/counties', 'CountiesController@index');
$router->post('/counties', 'CountiesController@store');
$router->get('/counties/{countyId}', 'CountiesController@show');
$router->put('/counties/{countyId}', 'CountiesController@update');

/**
 * Population Routes
 */
$router->get('/populations', 'PopulationsController@index');
$router->post('/populations', 'PopulationsController@store');
$router->get('/populations/{populationId}', 'PopulationsController@show');
$router->put('/populations/{populationId}', 'PopulationsController@update');
$router->get('/populations/zipcode/{zipCode}', 'PopulationsController@find');