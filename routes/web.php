<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/threads');
});

// Thread
Route::delete('/threads/{thread}', 'ThreadController@destroy')->name('thread.delete');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}/replies', 'ThreadController@replies');
Route::get('/thread/create', 'ThreadController@create');
Route::post('/thread', 'ThreadController@store');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->middleware('channel')->name('thread.show');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

// Reply
Route::delete('reply/{reply}', 'ReplyController@destroy');
Route::post('reply/{thread}', 'ReplyController@store');
Route::patch('reply/{reply}', 'ReplyController@update');

// Favorite
Route::post('favorite/reply/{reply}', 'FavoritesController@reply');
Route::delete('favorite/reply/{reply}', 'FavoritesController@replyUnfavorite');

// Channel
Route::post('channel', 'ChannelController@store');
Route::get('/thread/channels', 'ChannelController@channels');
Route::get('/channel', 'ChannelController@index');
Route::get('/channel/{channel}', 'ChannelController@show')->middleware('channel');
Route::any('channel/access/{channel}/password', 'ChannelController@password');
Route::get('channel/{channel}/subscribe', 'ChannelController@subscribe');


Route::post('lol', function () {
  $path = request()->file('image')->store('public/' . md5(auth()->user()->name . auth()->id()));
  return \Illuminate\Support\Facades\Storage::url($path);
});