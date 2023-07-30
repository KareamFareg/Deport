<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Services\VerificationService;
use App\User;
use App\Helpers\UtilHelper;
use Auth;

class VerificationController extends AdminController
{
    private $verificationServ;

    public function __construct(VerificationService $verificationService)
    {
      $this->verificationServ = $verificationService;
    }

    public function show()
    {

        if (session()->has('first_time')) {
          sleep(30);
        }
        session(['first_time' => true]);


        // save current user in session , and logout to can make the user or other users go to login page
        // so check if auth user bcause user can refresh the page so no user after logged out
        if (Auth::check()) {
          if(auth()->user()->isVerified(1)) {
            return redirect()->route('admin.home');
          }

          session(['user' => Auth::user()->id]);

          Auth::logout();
        }

        if (session()->has('user')) {
          $userVerification = $this->verificationServ->getUserVerification(session('user'));
          if ($userVerification) {
            $code = $userVerification->last()->code;
          } else {
            $code = $this->verificationServ->createVerification(session('user'));
          }

          return view('admin.verifications.show',compact('code'));
        } else {
          session()->forget('first_time');
          return redirect()->route('admin.login');
        }

    }

    public function check(Request $request)
    {

        if (session()->has('user')) {
          $user = User::where('id' , session('user'))->first();
          if (! $user) {
            return redirect()->route('admin.login');
          }

          if($user->isVerified(1)) {
            return redirect()->route('admin.home');
          }

          $userVerification = $this->verificationServ->getUserVerification($user->id);
          if (!$userVerification) {
            return redirect()->route('admin.login');
          }

          $checkVerificationCode = $this->verificationServ->checkVerificationCode($userVerification,$request->code);
          if (!$checkVerificationCode) {
            session()->forget('first_time'); // to run show without waiting
            return back()->withinput()->withErrors(['code' => __('verification.wrong_verification_code') ]);
          }



          session()->forget('first_time');
          session()->forget('user');
          Auth::login($user);

          // $this->flashAlert([
          //   'success' => ['msg'=> __('verification.verification_success') ]
          // ]);
          session(['flashAlerts' => [
              'success' => ['msg'=> __('verification.verification_success') ]
            ]
          ]);

          return redirect()->route('admin.home');

        }

        return redirect()->route('admin.login');

    }


}
