<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get('/', 'PagesController@index')->name('home');
Route::get('/edit', 'PagesController@edit')->name('edit');

Route::post('/entires', 'DataController@addEntires')->name('entires.submit');
Route::post('/entires/edit', 'DataController@updateEntires')->name('entires.update');
Route::post('/entires/delete', 'DataController@deleteEntires')->name('entires.delete');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});
