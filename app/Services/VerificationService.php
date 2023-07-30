<?php

namespace App\Services;
use App\Models\Verification;
use App\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use App\Helpers\UtilHelper;

class VerificationService
{

    public function createVerification($userId)
    {
        $oldVerifications = Verification::where('user_id',$userId)->delete();

        $newVerification = new Verification();
        $newVerification->user_id = $userId;
        $newVerification->code = rand(999, 9999);
        $newVerification->save();
        
        return $newVerification->code;

    }

    public function getUserVerification($user_id)
    {
      $userVerification = Verification::where('user_id',$user_id)->get();
      if ($userVerification->isEmpty()) {
        return false;
      }
      return $userVerification;
    }

    public function checkVerificationCode($userVerification,$code)
    {
        if( $userVerification->last()->code == $code) {
            User::where('id',$userVerification->last()->user_id)->update(['is_verified'=>1]);
            Verification::where('user_id', $userVerification->last()->user_id)->delete();
            return true;
        } else {
          return false;
        }
    }

    public function createVerificationEmail($user_id,$email)
    {
        $oldtokens = PasswordReset::where('email',$email)->delete();

        $token = PasswordReset::create(['email'=>$email , 'token'=> Str::random(64) , 'user_id' => $user_id , 'created_at' => UtilHelper::currentDate()  ]);

        return $token;

    }

    public function checkVerificationCodePassword($userVerification,$code)
    {
        // the defferance between this function and above function that we will not delete the code
        // because we will use it to verify agin in change password and there we will delete the code
        if( $userVerification->last()->code == $code) {
            return true;
        } else {
          return false;
        }
    }



}
