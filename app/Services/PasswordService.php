<?php

namespace App\Services;
use App\User;
use Validator;

class PasswordService
{


  public function validateForgotEmail($request)
  {
      $validator = Validator::make($request, [
          'email' => 'required|email',
      ]);

      if ($validator->fails()) {
        return $validator;
      }
      return true;

  }

  public function validateForgotPaswword($request)
  {
      $validator = Validator::make($request, [
          'phone' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return $validator;
      }
      return true;

  }

  public function validateUser($user)
  {
        // for mobile and email
        if (! $user ) {
          return trans('auth.user_not_found');
        }

        if ($user->isVerified(0)) {
          return trans('auth.not_verified');
        }

        if ($user->isActive(0)) {
          return trans('auth.in_active');
        }

        if ($user->isActiveAdmin(0)) {
          return trans('auth.in_active');
        }

        return true;
  }


  public function verifyPasswordCode($code)
  {

    $verificationServ = new \App\Services\VerificationService();

    $userVerification = $verificationServ->getUserVerification(session('user'));
    if (! $userVerification) {
      return trans('verification.error_verification_code');
    }

    $checkVerificationCode = $verificationServ->checkVerificationCodePassword($userVerification,$code);
    if (!$checkVerificationCode) {
      return trans('verification.wrong_verification_code');
    }

    return true;

  }




}
