<?php

namespace App\Traits;
use Request;
use Illuminate\Support\Facades\View;

trait AdminTrait
{
  public function checkPrivilege()
  {
        //$RouteName= (\Request::route()->getAction());
        //dd(class_basename($RouteName['controller']));
        //$RouteName= (\Request::route()->getName());

        // return true;
        $userPrivileges = optional(Request::User()->roles()->first())->privileges;
        $privileges = explode(',', $userPrivileges);
        if (array_search( Request::route()->getName() , $privileges ) === (bool) false) {
          return false;
        }

        View::share('privileges', $privileges);
        return true;

    }
}
