<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rotas de Páginas comuns
Route::get('/', 'PagesController@welcome');
Route::get('/about', 'PagesController@about');
Route::get('/teste', 'PagesController@teste');
Route::get('/services', 'PagesController@services');

//Rotas da Empresa
Route::resource('cadastros', 'EmpresaController');
Route::post('/cadastros/create', 'EmpresaController@store');
Route::post('cadastros/{empresa}/update', 'EmpresaController@update')->name('cadastroEmpresa.update');
Route::post('/cadastros/{empresa}/excluirCadastro', 'EmpresaController@excluirCadastro')->name('cadastroEmpresa.excluirCadastro');

//Rotas de PDV
Route::resource('cadastros/PDV', 'PDVController');
Route::get('/cadastros/{empresa}/PDV', 'PDVController@create')->name('cadastroPDV.create');
Route::get('/cadastros/{empresa}/PDV/{pdv}', 'PDVController@show');
Route::post('/cadastros/PDV/{pdv}/update', 'PDVController@update')->name('cadastroPDV.update');
Route::post('/cadastros/{empresa}/PDV/create', 'PDVController@store')->name('cadastroPDV.store');
Route::post('/cadastros/PDV/{pdv}/destroy', 'PDVController@destroy')->name('pdv.destroy');

//Rotas de Autenticação de usuário
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Rotas do Usuário
Route::resource('profile', 'Auth\UserController');
Route::get('profile.show', 'Auth\UserController@show');
Route::post('/profie/{user}/update', 'Auth\UserController@update')->name('user.update');
Route::post('/profie/{user}/perfil', 'Auth\UserController@perfil')->name('user.perfil');

//Rotas Laudo
Route::resource('laudo', 'LaudoController');
Route::post('laudo/create', 'LaudoController@store');
Route::post('laudo/{laudo}/update', 'LaudoController@update')->name('laudo.update');
Route::get('/getPDVs', 'LaudoController@getPDVs');
Route::get('/getModelosStore', 'LaudoController@getModelosStore');
Route::get('/getModelosAnaliseStore', 'LaudoController@getModelosAnaliseStore');
Route::get('/getModelosUpdate', 'LaudoController@getModelosUpdate');
Route::get('/getModelosAnaliseUpdate', 'LaudoController@getModelosAnaliseUpdate');
Route::post('/carregarArquivos', 'LaudoController@carregarArquivos')->name('laudo.carregarArquivos');
Route::post('/laudo/{laudo}/destroy', 'LaudoController@destroy')->name('laudo.destroy');
Route::get('laudo/{laudo}/gerarDocumentos', 'LaudoController@viewGerarDocs')->name('laudo.gerarDocumentos');
Route::get('/gerarLaudo/{laudo}', 'LaudoController@gerarLaudo')->name('laudo.gerarLaudo');
Route::get('get/file', function () {
    return Storage::download('path to file');
});

//Rotas ECFs
Route::resource('ecfs', 'ECFsController');

//Rotas Calendário
Route::get('/calendario', 'FullCalendarController@index')->name('index'); //renderiza o calendario
Route::get('/load-events', 'EventController@loadEvents')->name('routeLoadEvents'); //renderiza os eventos
Route::put('/update-event', 'EventController@update')->name('routeEventUpdate'); //att os eventos - put -> update
Route::post('/store-event', 'EventController@store')->name('routeEventStore'); //exclui os eventos
Route::delete('/destroy-event', 'EventController@destroy')->name('routeEventDelete'); //exclui os eventos


//Rotas Google
Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('google');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
