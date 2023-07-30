<?php

namespace App\Services;
use App\Models\UserType;

class UserTypeService
{

  public function getAll()
  {
    return UserType::all();
  }

  public function getClientUserTypes()
  {
    return UserType::wherein('id',['1','3'])->get(); // only shop and delegate of shope
  }

  public function checkInClientUserTypes($typeId)
  {
      if (array_search( $typeId , ["1","3"]  ) === (bool) false) {
        return false;
      }

      return true;
  }

  public function getAdminUserTypes()
  {
    return UserType::wherein('id',['4'])->get();
  }


  public function getSubscriptionUserTypes()
  {
    return UserType::wherein('id',['1','2'])->get(); // only shop and free delegate
  }

  public function checkInSubscriptionUserTypes($typeId)
  {
      if (array_search( $typeId , ["1","2"]  ) === (bool) false) {
        return false;
      }

      return true;
  }

  public function checkAlloewdAdminUserTypes($typeId)
  {
    // used in Admin Midelware. only shop and admin can access admin Panel
    if (array_search( $typeId , ["1","4"]  ) === (bool) false) {
      return false;
    }

    return true;
  }

}
