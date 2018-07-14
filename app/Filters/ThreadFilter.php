<?php
namespace App\Filters;

use Illuminate\Support\Facades\Auth;

class ThreadFilter extends Filter
{
  protected $filters = ['popular', 'unpopular'];

  public function popular()
  {
    $this->builder->getQuery()->orders = [];
    return $this->builder->orderBy('replies_count', 'desc');
  }

  public function unpopular()
  {
    return $this->builder->where('replies_count', 0);
  }
}