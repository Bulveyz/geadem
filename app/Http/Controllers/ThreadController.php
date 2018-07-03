<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ThreadController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Channel $channel, ThreadFilter $filter)
  {
    $threads = $this->getThreads($channel, $filter);
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

  public function channel(Request $request)
  {
    $this->validate($request, [
       'name' => ['unique:channels']
    ]);

    $channel = Channel::create([
        'name' => $request->name,
        'slug' => $request->name,
    ]);

    if (\request()->expectsJson()) {
      return $channel;
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  public function channels()
  {
    return Channel::latest()->get();
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
    //
  }

  /**
   * @param Channel $channel
   * @param ThreadFilter $filter
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
   */
  protected function getThreads(Channel $channel, ThreadFilter $filter)
  {
    $threads = Thread::latest()->filters($filter);
    if ($channel->exists) {
      $threads = $channel->threads()->latest();
    }
     $threads = $threads->paginate(10);
    return $threads;
  }
}
