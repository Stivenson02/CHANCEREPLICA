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

Route::get('user/{id}', [
  'uses' => 'UserController@index',
  'as' => 'user_phat'
]);

Route::get('insertus/{json}', [
  'uses' => 'UserController@store',
  'as' => 'insertus_phat'
]);

Route::get('insertchance/{json}', [
  'uses' => 'UserController@create',
  'as' => 'insertchance_phat'
]);

Route::get('alluser', [
  'uses' => 'UserController@show',
  'as' => 'alluser_phat'
]);

Route::get('sortear', [
  'uses' => 'UserController@sortea',
  'as' => 'sortear_phat'
]);

Route::get('ventasall', [
  'uses' => 'UserController@ventasall',
  'as' => 'ventasall_phat'
]);

