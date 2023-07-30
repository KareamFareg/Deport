<?php

namespace App\Http\Controllers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VerificationService;
use App\Services\PasswordService;
use App\User;
use App\Helpers\UtilHelper;
use Auth;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\Mail\MainEmail;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    private $verificationServ;
    private $passwordServ;

    public function __construct(VerificationService $verificationService,PasswordService $passwordService )
    {
      $this->verificationServ = $verificationService;
      $this->passwordServ = $passwordService;
    }

    public function showEmailRequest()
    {
      return view('util.password.show-email');
    }

    public function sendEmailReset(Request $request)
    {

        $request->flash();

        $validate = $this->passwordServ->validateForgotEmail($request->all());
        if ($validate !== true) {
            return back()->withinput()->withErrors($validate); // UtilHelper::prepareErrorBag($validate);
        }

        $user = User::where('email', $request->email)->first();
        $validate = $this->passwordServ->validateUser($user);
        if ($validate !== true) {
            return back()->withErrors(['general' => $validate]);
        }

        $verification_token = $this->verificationServ->createVerificationEmail($user->id,$user->email);

        // send mail
        $data = new \stdClass();
        $data->link = route('password.email.verify' , [ 'token' => $verification_token->token ] );
        $data->description = 'برجاء الضغط على الرابط لإعادة تعيين كلمة المرور';
        $data->sender = 'thnaks from saudi-captain2030.com';
        $data->receiver = 'saudi-captain2030.com';
        Mail::to($user->email)
          ->send( new MainEmail('util.password.send-email',$data) );


        session()->forget('flashAlerts');
        session(['flashAlerts' => [
            'success' => ['msg'=> __('passwords.sent') ]
          ]
        ]);

        return back();

    }

    public function verifyEmail(Request $request)
    {

        // $validate = $request->validate([
        //     'token' => 'required|string',
        // ]);

        session()->forget('flashAlerts');

        $verifyToken = PasswordReset::where('token',$request->token)->first();
        if (! $verifyToken) {
          $this->flashAlert([
            'fail' => ['msg'=> __('auth.password_reset_link_wrong')]
          ]);
          return redirect(route('password.email.request'));
        }

        return view('util.password.change-password',compact('verifyToken'));

    }

    public function changePasswordEmail(Request $request)
    {

        $validate = $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|max:12|confirmed',
        ]);

        $verifyToken = PasswordReset::where('token',$request->token)->first();
        if (! $verifyToken) {
          return back()->withErrors(['general' => __('auth.password_reset_link_wrong')]);
        }

        $user = User::where('email', $verifyToken->email)->first();
        $validate = $this->passwordServ->validateUser($user);
        if ($validate !== true) {
            return back()->withErrors(['general' => $validate]);
        }

        $user->Update(['password' => Hash::make($request->password) ]);

        PasswordReset::where('email',$user->email)->delete();

        $this->flashAlert([
          'success' => ['msg'=> __('auth.password_updated')]
        ]);

        return redirect('admin.login');

    }


    // mobile
    public function showMobileRequest()
    {
      // return view('front.password.show');
    }


    public function resetMobilePassword(Request $request)
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
