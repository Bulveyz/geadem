<?php

namespace App;


trait Favorite
{
  public function favorites()
  {
    return $this->morphMany(Favorites::class, 'favorite');
  }

  public function unfavorite()
  {
    $data = ['user_id' => auth()->user()->id];
    return $this->favorites()->where($data)->delete();
  }

  public function favorite()
  {
    $data = ['user_id' => auth()->user()->id];
    if (!$this->favorites()->where($data)->exists()) {
      return $this->favorites()->create($data);
    }
  }

  public function isFavorited()
  {
    return !! $this->favorites()->where('user_id', auth()->user()->id)->count();
  }

  public function getIsFavoritedAttribute()
  {
    return $this->isFavorited();
  }

  public function getFavoritesCountAttribute()
  {
    return $this->favorites->count();
  }
}