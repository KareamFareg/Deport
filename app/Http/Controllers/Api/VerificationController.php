<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Services\VerificationService;
use App\Traits\ApiResponse;

class VerificationController extends Controller
{
  use ApiResponse;
  private $verificationServ;

  public function __construct(VerificationService $verificationService)
  {
      $this->verificationServ = $verificationService;
  }

  public function createVerificationCode(Request $request)
  {
    $this->validate($request, [
       'user_id' => 'required|integer|exists:users,id',
    ]);

    $data = $this->verificationServ->createVerification($request->user_id);
    $response = [
         'data' => $data
    ];
    return $this->responseSuccess($response,200);
  }

  public function checkVerificationCode(Request $request)
  {
      $this->validate($request, [
         'user_id' => 'required|integer',
         'code' => 'required|string',
      ]);

      $user = User::findOrFail($request->user_id);

      if($user->isVerified(1)) {
          $response = ['errors' => [ 'verification' =>  trans('verification.already_verified')] ];
          return $this->responseFaild($response,422);
      }


      $userVerification = $this->verificationServ->getUserVerification($request->user_id);
      if (! $userVerification) {
        $response = [ 'errors' => [ 'verification' =>  trans('verification.error_verification_code')] ];
        return $this->responseFaild($response,422);
      }


      $checkVerificationCode = $this->verificationServ->checkVerificationCode($userVerification,$request->code);
      if (!$checkVerificationCode) {
        $response = [ 'errors' => [ 'verification' =>  trans('verification.wrong_verification_code')] ];
        return $this->responseFaild($response,422);
      }

      // send success
      $response = [
           'message' => [ 'sucess' =>  trans('verification.verification_success') ],
      ];
      return $this->responseSuccess($response,200);


  }

  public function checkVerificationCodePassword(Request $request)
  {
      $user = User::where('phone',$request->phone)->firstorfail();

      if($user->isVerified(0)) {
          $response = [
              'errors' => [ 'verification' => trans('verification.not_verified') ],
          ];
          return $this->responseFaild($response,422);
      }


      $userVerification = $this->verificationServ->getUserVerification($user->id);
      if (! $userVerification) {
        $response = [
            'errors' => [ 'verification' => trans('verification.error_verification_code') ],
        ];
        return $this->responseFaild($response,422);
      }


      $checkVerificationCode = $this->verificationServ->checkVerificationCodePassword($userVerification,$request->code);
      if (!$checkVerificationCode) {
        $response = [
            'errors' => [ 'verification' =>  trans('verification.wrong_verification_code') ],
        ];
        return $this->responseFaild($response,422);
      }

      // send success
      $response = [
           'message' => [ 'sucess' => trans('verification.verification_success') ],
      ];
      return $this->responseSuccess($response,200);


  }

}
