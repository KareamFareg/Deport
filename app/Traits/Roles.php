<?php

namespace App\Traits;
// use Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\View;
use Auth;

trait Roles
{

  public function _getRoleById($roleId)
  {

      $currentRole = Auth::user()->roles()->find($roleId);
      if (!$currentRole) {
        throw ValidationException::withMessages(['general' => __( 'messages.error_belongs_to_user'.Auth::user()->GenderAlias , [ 'var' => __('role.title') ] ) ]);
      }

      return $currentRole;
  }

  public function _setCurrentRole($roleId)
  {

    $currentRole = $this->_getRoleById($roleId);

    View::share( 'currentRole', $currentRole );
    session(['currentRole' => $currentRole]);

  }

  public function _getCurrentRole()
  {

    if (session()->has('currentRole') ) {
        $sessionRole = session('currentRole');
        $currentRole = $this->_getRoleById($sessionRole->id);
        View::share( 'currentRole', $currentRole );
        return $currentRole;
    }

    $defaultRole = Auth::user()->primaryRole()->first();
    if (! $defaultRole) {
      throw new ModelNotFoundException(__('role.not_found') );
    }

    View::share( 'currentRole', $defaultRole );
    session(['currentRole' => $defaultRole]);

    return $defaultRole;

  }
}
