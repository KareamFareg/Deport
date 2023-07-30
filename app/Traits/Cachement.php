<?php

namespace App\Traits;
use Illuminate\Support\Facades\Cache;

trait Cachement
{
  public function cacheHas($key)
  {
    return Cache::has($key);
  }

  public function cacheGet($key)
  {
    return Cache::get($key , null);
  }

  public function cachePut($key, $value, $minutes)
  {
    Cache::put($key, $value, $minutes);
  }

  public function cacheForever($key, $value)
  {
    Cache::forever($key, $value);
  }

  public function cacheForget($key)
  {
    Cache::forget($key);
  }

  public function cacheFlush()
  {
    Cache::flush();
  }


  public function cacheClearGroup($group)
  {

      try
      {
        if ($group =='categories')
        {
          foreach ( \App\Models\language::all() as $language)
          {
            Cache::forget('categories'.'-'.$language->locale);
            Cache::forget('categories-tree'.'-'.$language->locale);
            Cache::forget('services-tree'.'-'.$language->locale);
          }
        }
      }
      catch(\Exception $e)
      {return false;} //{return $e->getMessage();}  //

      return true;

  }

}
