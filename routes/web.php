<?php
use Illuminate\Support\Facades\Route;

Route::get('/threads/{channel?}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}/replies', 'ThreadController@replies');
Route::get('/thread/create', 'ThreadController@create');
Route::get('/thread/channels', 'ThreadController@channels');
Route::post('/thread/new/channel', 'ThreadController@channel');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('thread.show');
Route::get('logout', 'Auth\LoginController@logout');
Route::delete('reply/{reply}', 'ReplyController@destroy');
Route::post('reply/{thread}', 'ReplyController@store');
Route::patch('reply/{reply}', 'ReplyController@update');
Route::post('favorite/reply/{reply}', 'FavoritesController@reply');
Route::delete('favorite/reply/{reply}', 'FavoritesController@replyUnfavorite');
Auth::routes();
Route::post('channel', 'ChannelController@store');
