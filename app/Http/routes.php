<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();

Route::get('', 'HomeController@index');

Route::get('cas', 'Auth\AuthController@authenticated');

Route::get('excel/export/{serialNumber}', 'ExcelController@export');
Route::post('excel/import', 'ExcelController@import');
Route::get('excel/template', function () {
    return response()->download(
        realpath(base_path('public/importExcel')) . '/导入模板.xls',
        '导入模板.xls'
    );
});


/*
 * activate
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'book'], function () {
        Route::get('/', 'HomeController@showAddBook');
        Route::post('/', 'HomeController@addBook');
        Route::get('upload', 'HomeController@getUpload');
        Route::post('upload', 'HomeController@createBookList');
        Route::get('/{book}', 'HomeController@showUpdateBook');
        Route::patch('/{book}', 'HomeController@updateBook');
        Route::delete('/{book}', 'HomeController@deleteBook');
        Route::get('detail/{serialNumber}', 'HomeController@showDetail');
    });

    Route::group(['prefix' => 'booklist'], function () {
        Route::get('/{book}', 'HomeController@showUpdateBooklist');
    });
    Route::group(['prefix' => 'history'], function () {
        Route::get('/all', 'HomeController@showHistory');
        Route::get('/pass', 'HomeController@getCheckedBooks');
        Route::get('/unpass', 'HomeController@getUnpassBooks');
    });


    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('', 'AdminController@index');
        Route::get('/checked', 'AdminController@showCheckedList');
        Route::get('/checked/{serialNumber}', 'AdminController@getTheBookList');
        Route::get('/unchecked', 'AdminController@showUncheckedList');
        Route::get('/unchecked/{serialNumber}', 'AdminController@showTheCheckList');
        Route::post('/success/{serialNumber}', 'AdminController@checkTheList');
        Route::post('/error/{serialNumber}', 'AdminController@rejectTheList');
    });
});


Route::get('/home', 'HomeController@index');