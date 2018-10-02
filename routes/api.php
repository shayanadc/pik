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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('users','UserController@store');
Route::post('users/group','UserController@assignUsersToGroup');
Route::get('groups/user/{id}','GroupController@getGroupsOfUser');
Route::post('groups','GroupController@store');
Route::post('bills','BillController@store');
Route::post('ledgers','LedgerController@store');
Route::get('ledgers','LedgerController@index');
