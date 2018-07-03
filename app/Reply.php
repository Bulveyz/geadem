<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
  use Favorite;

  protected $guarded = [];
  protected $appends = ['favoritesCount', 'IsFavorited'];

  protected static function boot()
  {
    parent::boot();
    self::created(function ($model) {
      $model->thread->increment('replies_count');
    });

    self::deleting(function ($model) {
      $model->thread->decrement('replies_count');
      $model->favorites->each->delete();
    });
  }

  public function owner()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function thread()
  {
    return $this->belongsTo(Thread::class, 'thread_id');
  }
}
