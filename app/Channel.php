<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
  protected $guarded = [];

  protected $appends = ['IsSubscribedTo'];

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function threads()
  {
    return $this->hasMany(Thread::class, 'channel_id');
  }

  public function subscription($userId = null)
  {
    return $this->subscriptions()->create([
        'user_id' => $userId ?: auth()->id()
    ]);
  }

  public function unsubscription($userId = null)
  {
    return $this->subscriptions()->where(
        'user_id', $userId ?: auth()->id())
        ->delete();
  }

  public function subscriptions()
  {
    return $this->hasMany(ChannelSubscription::class);
  }

  public function getIsSubscribedToAttribute()
  {
    return $this->subscriptions()->where('user_id', auth()->id())->exists();
  }
}
