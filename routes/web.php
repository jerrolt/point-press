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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/journalist/all', 'AdminJournalistController@all')->name('journalists');
Route::post('/admin/journalist/restore/{journalist}', 'AdminJournalistController@restore');
Route::resource('/admin/journalist', 'AdminJournalistController');

Route::get('/admin/platform/all', 'AdminPlatformController@all');
Route::post('/admin/platform/restore/{platform}', 'AdminPlatformController@restore');
Route::resource('/admin/platform', 'AdminPlatformController');

Route::get('/admin/websites', 'AdminWebsiteController@all')->name('websites');
Route::get('/admin/platform/{platform}/websites', 'AdminPlatformController@websites');
Route::post('/admin/website/restore/{website}', 'AdminWebsiteController@restore');
Route::delete('/admin/website/permanent-delete/{website}', 'AdminWebsiteController@hardDelete');
Route::resource('/admin/website', 'AdminWebsiteController');


//Route::get('/admin/post/{post}/sources', 'AdminPostController@sources');
//Route::patch('/admin/post/{post}/sources', 'AdminPostController@updateSources');
Route::get('/admin/posts', 'AdminPostController@all')->name('posts');
Route::post('/admin/post/restore/{post}', 'AdminPostController@restore');
Route::resource('/admin/post', 'AdminPostController');