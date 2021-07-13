<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function() {
    // Controller check role & redirect user login as role
    Route::get('/', 'DashboardController@index');
    // End Controller check role & redirect user login as role

    // Controller dashboard admin
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
        Route::get('/guru', 'AdminController@guru')->name('admin.guru');
        Route::get('/siswa', 'AdminController@siswa')->name('admin.siswa');
    });
    // End Controller dashboard admin

    // Controller dashboard guru
    Route::group(['prefix' => 'guru', 'middleware' => 'guru'], function() {
        Route::get('/', 'GuruController@index')->name('guru.dashboard');
    });
    // End Controller dashboard guru

    // Controller dashboard siswa
    Route::group(['prefix' => 'siswa', 'middleware' => 'siswa'], function() {
        Route::get('/', 'SiswaController@index')->name('siswa.dashboard');
    });
    // End Controller dashboard siswa
});

// Route::get('/home', 'HomeController@index')->name('home');
