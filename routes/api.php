<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'namespace' => 'Api',
], function () {
    //busca empenhos via ajax
    Route::get('/empenho', 'EmpenhoController@index');
    Route::get('/empenhodetalhado', 'EmpenhodetalhadoController@index');
    Route::get('/credor', 'CredorController@index');
    Route::get('/unidade', 'UnidadeController@index');
    Route::get('/planointerno', 'PlanointernoController@index');
    Route::get('/empenho/{id}', 'EmpenhoController@show');
});


