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
    //API leitura de arquivos qware (STA)
    Route::get('/ler/empenho', 'EmpenhoController@ler');
    Route::get('/ler/empenhodetalhado', 'EmpenhodetalhadoController@ler');
    Route::get('/ler/credor', 'CredorController@ler');
    Route::get('/ler/unidade', 'UnidadeController@ler');
    Route::get('/ler/planointerno', 'PlanointernoController@ler');
    Route::get('/ler/ordembancaria/', 'OrdembancariaController@ler');
    Route::get('/ler/dochabil', 'DocHabilController@ler');

    //API Consulta Banco de Dados
    Route::get('/empenho/{dado}', 'EmpenhoController@buscaEmpenhoPorNumero');
    Route::get('/empenho/ano/{ano}/ug/{ug}/', 'EmpenhoController@buscaEmpenhoPorAnoUg');
    Route::get('/empenhodetalhado/{dado}', 'EmpenhodetalhadoController@buscaEmpenhodetalhadoPorNumeroEmpenho');
    Route::get('/ordembancaria/favorecido/{dado}', 'OrdembancariaController@buscaOrdembancariaPorCnpj');
    Route::get('/ordembancaria/ano/{ano}/ug/{ug}', 'OrdembancariaController@buscaOrdembancariaPorAnoUg');
    Route::get('/centrocusto/mesref/{mesref}/ug/{ug}', 'CentroCustoController@buscaCentroCustoPorMesrefUg');
});


