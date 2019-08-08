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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
  Route::get('novel/create', 'Admin\NovelController@add');
  Route::post('novel/create', 'Admin\NovelController@create');
  Route::get('novel/edit', 'Admin\NovelController@edit');
  Route::post('novel/edit', 'Admin\NovelController@update');
  Route::get('novel/delete', 'Admin\NovelController@delete');

  Route::get('story/create', 'Admin\StoryController@add');
  Route::post('story/create', 'Admin\StoryController@create');
  Route::get('story/edit', 'Admin\StoryController@edit');
  Route::post('story/edit', 'Admin\StoryController@update');
  Route::get('story/delete', 'Admin\StoryController@delete');

  Route::get('user/edit', 'Admin\UserController@edit');
  Route::post('user/edit', 'Admin\UserController@update');
  Route::get('user/delete', 'Admin\UserController@delete');

  Route::get('bookmark', 'Admin\BookmarkController@bookmark');
  Route::get('bookmark/cancel', 'Admin\BookmarkController@cancel');

  Route::get('marking', 'Admin\BookmarkController@marking');
  Route::get('marking/cancel', 'Admin\BookmarkController@noMarking');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/{id}', 'UserPageController@show');
Route::get('novel/{id}', 'UserNovelController@show')->name('novel');
Route::get('novel/{id}/story/{sort_num}', 'UserTextController@show');

Route::get('author', 'AuthorController@index');
Route::get('title', 'TitleController@index');
Route::post('title', 'TitleController@index');

Route::get('/', 'TopController@top');
