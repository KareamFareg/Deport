<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use App\Services\UserService;
use App\User;
use App\Models\UserType;
use App\Helpers\UtilHelper;
use App\Helpers\CoreHelper;
use Auth;

class SubscriptionController extends AdminController
{
    private $subscriptionServ;
    private $userServ;

    public function __construct(SubscriptionService $subscriptionService,UserService $userService)
    {
        $this->subscriptionServ = $subscriptionService;
        $this->userServ = $userService;

        $this->share([
          'page' => Subscription::PAGE,
          'recordsCount' => Subscription::count(),
        ]);

    }

    public function index(Request $request)
    {

        $subscriptionPackages = \App\Models\SubscriptionPackage::all();

        $users = \App\User::all('id','name');

        $data = Subscription::with(['subscriptionPackage','user.user_type']);
        if($request->subscription_packages_id) {
          $data->where('subscription_packages_id', $request->subscription_packages_id);
        }

        if($request->code) {
          $data->where('code', $request->code);
        }

        if($request->user_id) {
          $data->where('user_id', $request->user_id);
        }

        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active',$request->active_status);
        };

        if ($request->is_activated === "0" || $request->is_activated === "1" ) {
          $data->where('is_activated',$request->is_activated);
        };

        $data = $data->get();
        $request->flash();

        // dd($data);
        return view('admin.subscriptions.index',compact(['subscriptionPackages','users','data']));

    }

    public function getNewSubscriptions(Request $request)
    {

        $userTypes =  UserType::wherein('id',[1,2])->get();

        $data = User::with('subscription_packages')->wherehas('subscription_packages');

        if($request->user_type_id) {
          $data->where('type_id', $request->user_type_id);
        }

        $data = $data->get();
        $request->flash();

        return view('admin.subscriptions.new_subscriptions',compact(['userTypes','data']));

    }

    public function sendNewSubscription(Request $request)
    {

        $validate = $request->validate([
            'code' => 'required',
            'user_id' => 'required|integer|exists:users,id',
        ]);


        // check user
        $user = User::where('id',$request->user_id)->firstorfail();
        $checkUser = $this->userServ->checkUser($user); // active verfied ...
        if ($checkUser !== true) {
          return back()->withinput()->withErrors(['general' => $checkUser ]);
        }

        // check code
        $subscription = $this->subscriptionServ->getBySubscriptionCode($request->code);
        if (! $subscription) {
          return back()->withinput()->withErrors(['code' => __('subscription.code_not_found') ]);
        }

        $validateSubscription = $this->subscriptionServ->validateSubscription($subscription); // active .....
        if ($validateSubscription !== true) {
          return back()->withinput()->withErrors(['code' => $validateSubscription ]);
        }

        // send sms
        $user->Update(['subscription_sent_code' => $request->code ]);

        $request->flash();

        $this->flashAlert([
          'success' => ['msg'=> __('messages.updated') ]
        ]);
        return back();


    }

    public function create()
    {
        $subscriptionPackages = \App\Models\SubscriptionPackage::all();

        return view('admin.subscriptions.create',compact(['subscriptionPackages']));

    }

    public function store(Request $request)
    {


      $validate = $request->validate([
          'code' => 'required|string|max:7|unique:subscriptions',
          'subscription_packages_id' => 'required|integer|exists:subscription_packages,id',
      ]);


      Subscription::create(
        array_merge( $request->all(),
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
        )
      );

      return redirect(route('admin.subscriptionpackages.index'));

    }

    public function storeMany(Request $request)
    {

      $validate = $request->validate([
          'count' => 'required|integer|min:1|max:50',
          'subscription_packages_id' => 'required|integer|exists:subscription_packages,id',
      ]);

      $count = 0;
      do
      {
            do
            {
                $newCode = CoreHelper::generateRandomString(7);
                $check = Subscription::where('code', $newCode)->first();
            }
            while($check);

            Subscription::create([
                'subscription_packages_id' => $request->subscription_packages_id ,
                'code' => $newCode ,
                'ip' => UtilHelper::getUserIp() ,
                'access_user_id' => Auth::id()
            ]);
            $count = $count + 1;
      }
      while($count != $request->count);


      $this->flashAlert([
        'success' => ['msg'=> __('messages.added') ]
      ]);
      return back();

    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {


    }

    public function show()
    {

      if (session()->has('first_time_s')) {
        sleep(30);
      }
      session(['first_time_s' => true]);

        // save current user in session , and logout to can make the user go to login page
        // so check if auth user bcause user can refresh the page so no user after logged out
        if (Auth::check()) {
          session(['user_subscription' => Auth::user()->id]);
          Auth::logout();
        }

        if (session()->has('user_subscription')) {
          $code = \App\Models\Subscription::orderBy('id', 'desc')->first()->code;
          return view('admin.subscriptions.show',compact('code'));
        } else {
          session()->forget('first_time_s');
          return redirect()->route('admin.login');
        }

    }

    public function check(Request $request)
    {

        session()->forget('flashAlerts');



        if (session()->has('user_subscription')) {

          $user = User::where('id' , session('user_subscription'))->first();
          if (! $user) {
            return redirect()->route('admin.login');
          }


          // find code
          $subscription = $this->subscriptionServ->getBySubscriptionCode($request->code);
          if (! $subscription) {
            session()->forget('first_time_s');
            return back()->withinput()->withErrors(['code' => __('subscription.code_not_found') ]);
          }

          // activate
          $activateSubscription = $this->subscriptionServ->activateSubscriptionAll($subscription,$user->id);
          if ( $activateSubscription !== true) {
            session()->forget('user_subscription');
            session()->forget('first_time_s');
            return back()->withinput()->withErrors(['code' => $activateSubscription ]);
          }


          session()->forget('user_subscription');
          session()->forget('first_time_s');

          Auth::login($user);
          return redirect()->route('admin.home');

        }

        return redirect()->route('admin.login');

    }

    public function setActive(Request $request)
    {

        $subscription = Subscription::where('id',$request->id)->first();
        if (! $subscription) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $subscription->update(['is_active' => !$subscription->is_active ]);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }

        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();

    }

}
