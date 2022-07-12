<?php
use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;
// /** @var \Laravel\Lumen\Routing\Router 
//  * 
 

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

$router->group(['prefix' => 'api'], function() use ($router)
{
    $router->group(['prefix'=>'clients'],function() use ($router){
        $router->get('getAllData', [
            'as' => 'getAllDataClients', 'uses' => 'ClientsController@index'
        ]);
        $router->post('signUp', [
            'as' => 'registerClients', 'uses' => 'ClientsController@store'
        ]);
        $router->post('signIn', [
            'as' => 'loginClients', 'uses' => 'ClientsController@login'
        ]);
        $router->post('activatedAccounts', [
            'as' => 'activationAccount', 'uses' => 'ClientsController@activatedAccount'
        ]);
        $router->get('getDataClientsById/{id}', [
            'as' => 'getDataClientsById', 'uses' => 'ClientsController@show'
        ]);
    });
});
