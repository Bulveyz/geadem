<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Thread;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ThreadFilter $filter)
    {
      $threads = $this->getThreads($filter);
        return view('home.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel' => 'required',
        ]);

        if ($request->channel[0]['access'] != 'All') {
            if (auth()->user()->id == $request->channel[0]['user_id']) {
              $paths = [];
              foreach (request()->file('attachments') as $file) {
                $paths[] = $file->store('public/' . sha1(auth()->user()->name) . '/');
              }

                Thread::create([
                    'title' => $request->title,
                    'body' => $request->body,
                    'channel_id' => $request->channel[0]['id'],
                    'user_id' => auth()->user()->id,
                    'attachments' => serialize($paths),
                    'access' => $request->channel[0]['access']
                ]);

              return $paths;
            } else {
                if ($request->expectsJson()) {
                    return response('Access denide', 403);
                }
                return exit(403);
            }
        } else {
            Thread::create([
                'title' => $request->title,
                'body' => $request->body,
                'channel_id' => $request->channel[0]['id'],
                'user_id' => auth()->user()->id
            ]);
        }

        if ($request->hasFile('attachments') && $request->expectsJson()) {
          return $paths;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {

    }

    public function replies($channel, Thread $thread)
    {
        return $thread->replies()->with('owner')->latest()->paginate(10);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilter $filter
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    protected function getThreads(ThreadFilter $filter)
    {
        $threads = Thread::latest()->where('access', 'All')->filters($filter)->paginate(10);
        return $threads;
    }
}
