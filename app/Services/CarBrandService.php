<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Models\CarBrand;
use App\Models\CarBrandInfo;
use Auth;

class CarBrandService
{

  public function queryAll( $params = [], $language = null)
  {
  

  }

  public function store($request)
  {

      return CarBrand::create(
          array_merge( $request ,
              ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
          )
      );

  }

  public function storeInfo($request)
  {
      return CarBrandInfo::create($request);
  }

  public function update( $request , $carBrand )
  {

      // $carBrand->title_general = $request->title;
      $carBrand->ip = UtilHelper::getUserIp();
      $carBrand->access_user_id = Auth::id();
      $carBrand->save();

      return $carBrand;

  }

  public function updateInfo( $request , $carBrandInfo )
  {

      $carBrandInfo->title = $request['title'];
      $carBrandInfo->save();

      return $carBrandInfo;

  }


}
