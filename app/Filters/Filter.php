<?php
/**
 * Created by PhpStorm.
 * User: ruslanibragimov
 * Date: 01/07/2018
 * Time: 23:47
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filter
{
  protected $builder, $request;
  protected $filters = [];

  /**
   * Filter constructor.
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function apply($builer)
  {
    $this->builder = $builer;

    foreach ($this->getFilters() as $filter => $value) {
      if (method_exists($this, $filter)) {
        $this->$filter($value);
      } else {
        return $this->builder;
      }
    }
  }

  public function getFilters()
  {
    return $this->request->only($this->filters);
  }
}