<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChannelController extends Controller
{
  public function store(Request $request)
  {
    if ($request->get('hasPassword')) {
      $this->validate($request, [
          'channel_name' => 'unique:channels,name',
          'password' => 'required'
      ]);
    } else {
      $this->validate($request, [
          'channel_name' => 'unique:channels,name'
      ]);
    }

    $channel = Channel::create([
        'user_id' => auth()->user()->id,
        'name' => $request->channel_name,
        'access' => $request->channel_access,
        'slug' => $request->channel_name,
        'password' => Hash::make($request->password),
        'usersInvite' => null
    ]);

    if ($request->expectsJson()) {
      return $channel;
    }
  }
}
