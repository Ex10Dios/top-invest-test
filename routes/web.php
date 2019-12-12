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
Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);



Route::prefix('/candidates')->group(function () {
    Route::get('/', 'CandidatesController@index')->name('candidates.index');
    Route::get('/export', 'CandidatesController@export')->name('candidates.export');
    Route::get('/charts', 'CandidatesController@charts')->name('candidates.charts');
    Route::get('/add', 'CandidatesController@add')->name('candidates.add');
    Route::get('/edit/{candidate}', 'CandidatesController@edit')->name('candidates.edit');
    Route::post('/store', 'CandidatesController@store')->name('candidates.store');
    Route::put('/update/{candidate}', 'CandidatesController@update')->name('candidates.update');
});