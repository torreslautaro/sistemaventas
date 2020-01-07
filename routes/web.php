<?php

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

Route::get('/', function () {
    return view('contenido/contenido');
});
Route::get('/categorias','CategoriaController@index');
Route::post('/categorias/crear','CategoriaController@store');
Route::put('/categorias/actualizar','CategoriaController@update');
Route::put('/categorias/desactivar','CategoriaController@desactivar');
Route::put('/categorias/activar','CategoriaController@activar');
Route::get('/categorias/selectcategoria','CategoriaController@selectCategoria');

Route::get('/articulos','ArticuloController@index');
Route::post('/articulos/crear','ArticuloController@store');
Route::put('/articulos/actualizar','ArticuloController@update');
Route::put('/articulos/desactivar','ArticuloController@desactivar');
Route::put('/articulos/activar','ArticuloController@activar');

Route::get('/clientes','ClienteController@index');
Route::post('/clientes/crear','ClienteController@store');
Route::put('/clientes/actualizar','ClienteController@update');

Route::get('/proveedores','ProveedorController@index');
Route::post('/proveedores/crear','ProveedorController@store');
Route::put('/proveedores/actualizar','ProveedorController@update');

Route::get('/rol','RolController@index');

Route::get('/users','UserController@index');
Route::post('/users/crear','UserController@store');
Route::put('/users/actualizar','UserController@update');
Route::put('/users/desactivar','UserController@desactivar');
Route::put('/users/activar','UserController@activar');

Route::get('/prueba','PruebaController@index');

