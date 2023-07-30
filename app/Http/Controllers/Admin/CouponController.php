<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\Coupon;
use App\Services\CouponService;
use App\Services\UserService;
use App\User;
use App\Models\UserType;
use App\Helpers\UtilHelper;
use App\Helpers\CoreHelper;
use Auth;

class CouponController extends AdminController
{
    private $couponServ;
    private $userServ;

    public function __construct(CouponService $couponService,UserService $userService)
    {
        $this->couponServ = $couponService;
        $this->userServ = $userService;

        $this->share([
          'page' => Coupon::PAGE,
          'recordsCount' => Coupon::count(),
        ]);

    }

    public function index(Request $request)
    {

        $data = Coupon::query();

        
        if($request->is_activated === 1) {
          $data->whereRaw('use_limits = use_count');
        }

        if($request->is_activated === 0) {
          $data->whereRaw('use_limits > use_count');
        }

        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active',$request->active_status);
        };

        $data = $data->get();
        $request->flash();

        // dd($data);
        return view('admin.coupons.index',compact(['data']));

    }


    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {


      $validate = $request->validate([
          'code' => 'required|string|max:7|unique:coupons',
          'mount' => 'required|numeric|min:0|not_in:0',
          'use_limits' => 'required|integer|min:0|not_in:0',
          'expire_date' => 'required|date',
      ]);


      Coupon::create(
        array_merge( $request->all(),
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
        )
      );

      return redirect(route('admin.coupons.index'));

    }

    // public function storeMany(Request $request)
    // {
    //
    //   $validate = $request->validate([
    //       'count' => 'required|integer|min:1|max:50',
    //       'subscription_packages_id' => 'required|integer|exists:subscription_packages,id',
    //   ]);
    //
    //   $count = 0;
    //   do
    //   {
    //         do
    //         {
    //             $newCode = CoreHelper::generateRandomString(7);
    //             $check = Subscription::where('code', $newCode)->first();
    //         }
    //         while($check);
    //
    //         Subscription::create([
    //             'subscription_packages_id' => $request->subscription_packages_id ,
    //             'code' => $newCode ,
    //             'ip' => UtilHelper::getUserIp() ,
    //             'access_user_id' => Auth::id()
    //         ]);
    //         $count = $count + 1;
    //   }
    //   while($count != $request->count);
    //
    //
    //   $this->flashAlert([
    //     'success' => ['msg'=> __('messages.added') ]
    //   ]);
    //   return back();
    //
    // }

    public function edit(Request $request)
    {
        $data = Coupon::where('id',$request->id)->firstorfail();
        return view('admin.coupons.edit',compact('data'));
    }

    public function update(Request $request)
    {

      $coupon = Coupon::where('id',$request->id)->firstorfail();

      $validate = $request->validate([
          'code' => 'required|string|max:7|unique:coupons,id,'.$request->id,
          'mount' => 'required|numeric|min:0|not_in:0',
          'use_limits' => 'required|integer|min:0|not_in:0',
      ]);


      $coupon->update(
        array_merge( $request->all(),
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
        )
      );

      return redirect(route('admin.coupons.index'));

    }

    public function validateCoupone(Request $request)
    {


    }

    public function setActive(Request $request)
    {

        $coupon = Coupon::where('id',$request->id)->first();
        if (! $coupon) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $coupon->update(['is_active' => !$coupon->is_active ]);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }

        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();

    }

}
