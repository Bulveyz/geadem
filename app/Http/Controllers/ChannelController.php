<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChannelController extends Controller
{

    private $channel;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('channels.index', [
            'channels' => Channel::where('access', 'All')->latest()->get()
        ]);
    }

    public function show(Channel $channel)
    {
        $threads = $channel->threads()->get();
        return view('channels.show', compact('threads'));
    }

    public function password(Channel $channel, Request $request)
    {
        if ($channel->IsSubscribedTo || $channel->access != 'Password') {
          return redirect('channel/'.$channel->name);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Hash::check($request->password, $channel->password)) {
                \session([$channel->name . 'Access' => 1]);
                return response('Success!', 200);
            } else {
                return response('Password incorrect', 403);
            }
        }
        return view('channels.password', compact('channel'));
    }

    public function subscribe(Channel $channel)
    {
        if (\request()->expectsJson()) {
          if (!$channel->IsSubscribedTo && session()->has($channel->name . 'Access')) {
            $channel->subscription();
            \session()->forget($channel->name . 'Access');
            return response('Subscription added', 200);
          } else {
            return response('', 403);
          }
        }
    }

    public function store(Request $request)
    {
        if ($request->get('channel_access') == 'Password') {
            $this->validate($request, [
                'channel_name' => 'unique:channels,name',
                'password' => 'required'
            ]);

            $this->channel = Channel::create([
                'user_id' => auth()->user()->id,
                'name' => $request->channel_name,
                'access' => $request->channel_access,
                'slug' => $request->channel_name,
                'description' => $request->description,
                'password' => Hash::make($request->password),
                'usersInvite' => null
            ]);

        } elseif($request->get('channel_access') == 'All' || $request->get('channel_access') == 'Private') {
            $this->validate($request, [
                'channel_name' => 'unique:channels,name'
            ]);

          $this->channel = Channel::create([
                'user_id' => auth()->user()->id,
                'name' => $request->channel_name,
                'description' => $request->description,
                'access' => $request->channel_access,
                'slug' => $request->channel_name,
            ]);
        }


        if ($request->expectsJson()) {
            return $this->channel;
        }
    }

    public function channels()
    {
        $channels = Channel::latest()->where('access', 'All')->get();
        $myChannels = Channel::latest()->where('user_id', auth()->user()->id)->get();
        return json_encode([$channels, $myChannels]);
    }
}
