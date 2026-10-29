<?php

#MUY IMPORTANTE ESTE CAMPO, es para que web tenga acceso a los comandos de los controlador, sin ellos el sistema cree que los controladores no existen
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\SalidasController;
use Illuminate\Support\Facades\Route;

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
    #Ruta del indice de proveedores
    return redirect()->route('proveedores.index');
});

Route::resource('proveedores', ProveedorController::class);
Route::resource('productos', ProductoController::class);
Route::resource('entradas', EntradasController::class);
Route::resource('salidas', SalidasController::class);