<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread)
    {
        $reply = $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->user()->id
        ]);

        if (\request()->expectsJson()) {
            return $reply->load('owner');
        }
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(['body' => \request('body')]);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (\request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
    }
}
