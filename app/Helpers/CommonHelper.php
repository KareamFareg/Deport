<?php

namespace App\Helpers;
use App\Models\Language;
use App\Models\Order;
use App\Models\OrderStatus;

class CommonHelper
{

	public static function getDefultLanguage()
	{
		return Language::default()->active()->first();
	}

	public static function getContactUsTypes()
  {
    return \App\Models\ContactUsType::all();
  }

	public static function getLoginField()
	{
		// we will get the filed from settings(config or db) (for example 'phone') and search in $default,
		// if found return it else retuern default

		// ! important
		// must retuern data not empty or null

		$default = ['name','email','phone'];

		// default
		return ['field'=>'phone','verifyMsg'=>'verify_sms_msg'];
	}

	public static function menu_get($language_id)
  {
    // same as in front
	    if(!$language_id)
	    {
	      $language_id = language::where('isDefault','1')->select('id')->first();
	      $language_id=$language_id->id;
	    }

	    $menu_categoty=DB::Table('menu_details')
	              ->join('category_info', 'menu_details.ref_id', '=', 'category_info.category_id')
	              ->join('category', 'category.id', '=', 'category_info.category_id')
	              ->where('menu_details.type', '=', 'category')
	              ->where('category_info.language_id', '=', $language_id)
	              ->where('category.isActive', '=', 1)
	              ->select('menu_details.id','category.id as ref_id','menu_details.parent_id','menu_details.menu','menu_details.type','category_info.title','category_info.alias')
	              ->get();

	    $menu_info=DB::Table('menu_details')
	              ->join('pages_info', 'menu_details.ref_id', '=', 'pages_info.page_id')
	              ->join('pages', 'pages.id', '=', 'pages_info.page_id')
	              ->where('menu_details.type', '=', 'info')
	              ->where('pages_info.language_id', '=', $language_id)
	              ->where('pages.isActive', '=', 1)
	              ->select('menu_details.id','pages.id as ref_id','menu_details.parent_id','menu_details.menu','menu_details.type','pages_info.title','pages_info.alias')
	              ->get();

	    $menu = array_merge($menu_categoty->toArray(), $menu_info->toArray());
	    $menu=collect($menu)->sortBy('id');

	    return $menu;

  }





}
