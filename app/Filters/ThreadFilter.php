<?php
namespace App\Filters;

use Illuminate\Support\Facades\Auth;

class ThreadFilter extends Filter
{
  protected $filters = ['popular', 'my', 'unpopular'];

  public function popular()
  {
    $this->builder->getQuery()->orders = [];
    return $this->builder->orderBy('replies_count', 'desc');
  }

  public function my()
  {
    return $this->builder->where('user_id', \auth()->user()->id);
  }

  public function unpopular()
  {
    return $this->builder->where('replies_count', 0);
  }
}