<?php

namespace App\Services;
use App\Models\Role;
use App\Models\Privileg;
use App\Helpers\UtilHelper;

class RoleService
{

  public function getPrivilegsTree( $privilegs ,$privileg_id = 0 , $dont = null)
  {
    $temp = [];
    return UtilHelper::buildTreeRoot( $privilegs, $dont, $temp, $privileg_id, 0 );
  }

  public function getClientRoles()
  {
    return Role::where('role_for',1)->get();
  }



}
