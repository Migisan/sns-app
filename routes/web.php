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

/**
 * ユーザー認証
 */
Auth::routes();

/**
 * 記事
 */
Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles', 'ArticleController')->except(['index'])->middleware('auth');


