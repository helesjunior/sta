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
    Route::get('/ler/empenho', 'EmpenhoController@ler');
    Route::get('/empenho/{dado}', 'EmpenhoController@buscaEmpenhoPorNumero');
    Route::get('/ordembancaria/favorecido/{dado}', 'OrdembancariaController@buscaOrdembancariaPorCnpj');
    Route::get('/ordembancaria/ano/{ano}/ug/{ug}', 'OrdembancariaController@buscaOrdembancariaPorAnoUg');
    Route::get('/ler/empenhodetalhado', 'EmpenhodetalhadoController@ler');
    Route::get('/ler/credor', 'CredorController@ler');
    Route::get('/ler/unidade', 'UnidadeController@ler');
    Route::get('/ler/planointerno', 'PlanointernoController@ler');
    Route::get('/empenho/{id}', 'EmpenhoController@show');
    Route::get('/ler/ordembancaria/', 'OrdembancariaController@ler');
    Route::get('/ler/dochabil', 'DocHabilController@ler');
});


