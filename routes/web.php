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
        
        // Guru Crud
        Route::get('/guru', 'AdminController@guru')->name('admin.guru');
        Route::post('/guru', 'AdminController@guruPost')->name('admin.guru.post');
        Route::post('/guru/update', 'AdminController@guruUpdate')->name('admin.guru.update');
        Route::post('/guru/delete', 'AdminController@gutuDelete')->name('admin.guru.delete');
        Route::post('/guru/resetpassword', 'AdminController@guruResetPassword')->name('admin.guru.resetpassword');
        // End Guru Crud
        
        // Siswa Crud
        Route::get('/siswa', 'AdminController@siswa')->name('admin.siswa');
        Route::post('/siswa', 'AdminController@siswaPost')->name('admin.siswa.post');
        Route::post('/siswa/update', 'AdminController@siswaUpdate')->name('admin.siswa.update');
        Route::post('/siswa/delete', 'AdminController@siswaDelete')->name('admin.siswa.delete');
        Route::post('/siswa/resetpassword', 'AdminController@siswaResetPassword')->name('admin.siswa.resetpassword');
        // End Siswa Crud

        // Pelajaran Crud
        Route::get('/pelajaran', 'AdminController@pelajaran')->name('admin.pelajaran');
        Route::post('/pelajaran', 'AdminController@pelajaranPost')->name('admin.pelajaran.post');
        Route::post('/pelajaran/update', 'AdminController@pelajaranUpdate')->name('admin.pelajaran.update');
        Route::post('/pelajaran/delete', 'AdminController@pelajaranDelete')->name('admin.pelajaran.delete');
        // End Pelajaran Crud

        // Jadwal Crud
        Route::get('/jadwal', 'AdminController@jadwal')->name('admin.jadwal');
        Route::post('/jadwal', 'AdminController@jadwalPost')->name('admin.jadwal.post');
        Route::post('/jadwal/update', 'AdminController@jadwalUpdate')->name('admin.jadwal.update');
        Route::post('/jadwal/delete', 'AdminController@jadwalDelete')->name('admin.jadwal.delete');
        // End Jadwal Crud

        // Absen Crud
        Route::get('/absen', 'AdminController@absen')->name('admin.absen');
        // End Absen Crud

        Route::get('/nilai', 'AdminController@nilai')->name('admin.nilai');
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
