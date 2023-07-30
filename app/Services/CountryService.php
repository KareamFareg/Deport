<?php

namespace App\Services;

use App\Helpers\UtilHelper;
use App\Models\Country;
use App\Models\CountryInfo;
use App\Traits\Cachement;
use Auth;

class CountryService
{
    use Cachement;

    // return collection
    public function queryAll($params = [], $language = null)
    {

        $language = $language ?? app()->getLocale();
         return Country::select('countries.id', 'countries.parent_id', 'countries.is_active', "countries.title")->get();
    }

    // return collection
    public function getAll($language = null)
    {
        // $this->cacheFlush();

        $language = $language ?? app()->getLocale();

        // $cacheName = 'countries'.'-'.$language ;
        //
        // if ( $this->cacheHas($cacheName) ) {
        //   return $this->cacheGet($cacheName);
        // }

        $data = $this->queryAll([], $language);
        // $this->cacheForever($cacheName , $data);

        return $data;

    }

    // return Array
    public function getCountriesTree($language = null)
    {

        $this->cacheFlush();

        $language = $language ?? app()->getLocale();
        $cacheName = 'countries-tree' . '-' . $language;

        if ($this->cacheHas($cacheName)) {
            return $this->cacheGet($cacheName);
        }

        $data = UtilHelper::buildTree($this->getAll());
        $this->cacheForever($cacheName, $data);

        return $data;
    }

    public function store($request)
    {

        $country = new Country();
        $country->title = $request['title'];
        $country->parent_id = $request['parent_id'];
        $country->save();

        return $country;

    }



    public function update($request, $country)
    {
        $request->merge(['title' => array_merge($country->title, $request->title)]);
        $country->title = $request['title'];
        $country->parent_id = $request['parent_id'];
        $country->save();
        return $country;

    }



    public function setActive($country, $status)
    {

        $country->update(['is_active' => $status]);

        $childs = Country::where('parent_id', $country->id)->get();

        foreach ($childs as $child) {
            $this->setActive($child, $status);
        }

    }

}
