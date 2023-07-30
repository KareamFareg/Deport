<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VerificationService;
use App\Services\PasswordService;
use App\User;
use App\Helpers\UtilHelper;
use Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    private $verificationServ;
    private $passwordServ;

    public function __construct(VerificationService $verificationService,PasswordService $passwordService )
    {
      $this->verificationServ = $verificationService;
      $this->passwordServ = $passwordService;
    }

    public function showResetPassword()
    {
      return view('front.password.show');
    }

    public function resetPassword(Request $request)
    {

        $validate = $this->passwordServ->validateForgotPaswword($request->all());
        if ($validate !== true) {
            return back()->withinput()->withErrors($validate); // UtilHelper::prepareErrorBag($validate);
        }

        $user = User::where('phone', $request->phone)->first();
        $validate = $this->passwordServ->validateUser($user);
        if ($validate !== true) {
            return back()->withErrors(['general' => $validate]);
        }

        $verification_code = $this->verificationServ->createVerification($user->id);
        session(['user' => $user->id]);

        // send sms or
        session(['verification_code' => $verification_code]);

        return redirect(route('password.verify'));

    }

    public function showVerifyPassword()
    {

      $code = session('verification_code');
      return view('front.password.verify',compact('code'));

    }

    public function verifyPasswordCode(Request $request)
    {

      $this->validate($request, [
         'code' => 'required|numeric',
      ]);

      if (! session()->has('user')) {
          return redirect(route('password.reset'));
      }

      $verifyCode = $this->passwordServ->verifyPasswordCode($request->code);
      if ($verifyCode !== true) {
        return back()->withinput()->withErrors(['general' => $verifyCode]);
      }

      session()->forget('verification_code');

      session(['code' => $request->code]);
      return redirect(route('password.change'));

    }

    public function showChangePassword()
    {
      return view('front.password.change');
    }

    public function changePassword(Request $request)
    {
      $this->validate($request, [
         'password' => 'required|string|min:8|max:12|confirmed',
      ]);

      if (! session()->has('user')) {
          return redirect(route('password.reset'));
      }

      if (! session()->has('code')) {
          return redirect(route('password.reset'));
      }

      $user = User::where('id', session('user'))->firstorfail();
      $validate = $this->passwordServ->validateUser($user);
      if ($validate !== true) {
          return back()->withErrors(['general' => $validate]);
      }


      $verifyCode = $this->passwordServ->verifyPasswordCode(session('code'));
      if ($verifyCode !== true) {
        return back()->withinput()->withErrors(['general' => $verifyCode]);
      }


      \App\Models\Verification::where('user_id', session('user'))->delete();
      session()->forget('user');
      session()->forget('code');


      $user->password = Hash::make($request->password);
      $user->save();

      $this->flashAlert([
        'success' => ['msg'=> __('auth.password_updated')]
      ]);
      return redirect(route('front.login'));


    }

    public function resendCode()
    {

      if (! session()->has('user')) {
          return redirect(route('password.reset'));
      }

      $verification_code = $this->verificationServ->createVerification(session('user'));
      session(['user' => session('user')]);

      // send sms or
      session(['verification_code' => $verification_code]);

      return redirect(route('password.verify'));
    }

}
