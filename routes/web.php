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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/user', ['as' => 'user_index', 'uses' => 'UserController@index']);
    $router->post('user', ['as' => 'user_create', 'uses' => 'UserController@create']);
    $router->put('user/{id}', ['as' => 'user_edit', 'uses' => 'UserController@edit']);
    $router->delete('user/{id}', ['as' => 'user_destroy', 'uses' => 'UserController@destroy']);
//});
$router->post('/rating', ['as' => 'post_rating', 'uses' => 'RatingController@create']);
$router->get('/rating/{id}', ['as' => 'get_user_rating', 'uses' => 'RatingController@getIndividualRating']);
$router->get('/rating', ['as' => 'get_all_users_rating', 'uses' => 'RatingController@getAllUserRating']);
