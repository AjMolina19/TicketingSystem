<?php

use App\Http\Controllers\UserController;
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

Auth::routes();

Route::group(['middleware' => ['auth', 'users'], 'prefix' => 'users', 'as' => 'users.'], function () {
    // Users route
    Route::get('/', 'UserController@index')->name('dashboard');
    Route::post('/dashboard', 'UserController@store');
    Route::get('editticket/{id}', 'UserController@edit');
    Route::post('updateticket/{id}', 'UserController@update')->name('updateticket');

    Route::get('pendingticket', 'UserPendingController@index')->name('usersPending');

    Route::get('resolvedticket', 'UserResolvedController@index')->name('usersResolved');

    Route::get('archievedticket', 'UserArchievedController@index')->name('usersArchieved');
    
});

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin','as' => 'admin.'], function(){
    //Admin routes
    Route::get('/adminopen', 'AdminHomeController@index')->name('adminOpen');
    Route::get('adminopen/{id}', 'AdminHomeController@edit');
    Route::post('update/{id}', 'AdminHomeController@update');

    Route::get('/adminassigned', 'AdminAssignedController@index')->name('adminAssigned');

    Route::get('/adminresolved', 'AdminResolvedController@index')->name('adminResolved');

    Route::get('/adminarchieved', 'AdminArchievedController@index')->name('adminArchieved');
});


