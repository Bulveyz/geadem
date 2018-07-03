<?php

namespace App;

use App\Filters\ThreadFilter;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  protected $guarded = [];
  protected $with = ['channel:id,slug', 'creator:id,name'];

  public function channel()
  {
    return $this->belongsTo(Channel::class, 'channel_id');
  }

  public function creator()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function scopeFilters($query, ThreadFilter $filter)
  {
    return $filter->apply($query);
  }

  public function replies()
  {
    return $this->hasMany(Reply::class);
  }

  public function addReply($reply)
  {
    return $this->replies()->create($reply);
  }
}
