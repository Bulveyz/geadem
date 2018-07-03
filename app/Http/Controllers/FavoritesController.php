<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function reply(Reply $reply)
    {
      $reply->favorite();

      return back();
    }

    public function replyUnfavorite(Reply $reply)
    {
      $reply->unfavorite();
    }
}
