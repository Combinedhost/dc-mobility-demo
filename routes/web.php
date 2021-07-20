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
   $html = '<div><p>Dear {user-first-name} </p><p>Congratulations on joining DC Mobility!
        We\'re excited to have you with us.</p>
        <p>Your User ID: {user_id}</p>
        <p>We’ll send you another email with your tracking number as soon as your order has been shipped</p>
        <p>Here’s your address details:</p>
        <p>Email: {email}</p>
        <p>Phone: {phone}</p>
        <p>Address:  {address}</p>
        <p>Thanks,</p>
        <p>Team DC Mobility</p>
        </div>';
    return $html;
});


$router->post('api/users/register',  ['uses' => 'UserController@register']);
$router->post('api/send-email',  ['uses' => 'EmailController@sendEmail']);
$router->post('api/templates/create',  ['uses' => 'TemplateController@addTemplate']);

