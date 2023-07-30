<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Models\PackageType;
use App\Models\PackageTypeInfo;
use Auth;

class PackageTypeService
{

  public function getAll($language = null)
  {

  }

  public function store($request)
  {
      return PackageType::create( $request );
  }

  public function storeInfo($request)
  {

      return PackageTypeInfo::create( array_merge( $request ,
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
          )
      );

  }

  public function update( $request , $packageType )
  {

      $packageType->price = $request['price'];
      $packageType->save();

      return $packageType;

  }

  public function updateInfo( $request , $packageTypeInfo )
  {

      $packageTypeInfo->title = $request['title'];
      $packageTypeInfo->ip = UtilHelper::getUserIp();
      $packageTypeInfo->access_user_id = Auth::id();
      $packageTypeInfo->save();

      return $packageTypeInfo;

  }


}
