<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\AdminController;

use App\Models\Coupon;

class CouponsController extends AdminController
{
    public function index(Request $request)
    {

        $data = Coupon::orderBy('id','desc');

        $from = null;
        $to = null;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;

            if ($request->from != null) {$data->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$data->whereDate('created_at', '<=', $request->to);}
        }
        $data=$data->get();

        return view('admin.coupons.index', compact('data','from','to'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'coupon' => 'nullable|unique:coupons',
            'amount' => 'required|integer',
            'limit' => 'required|integer',
            'expire_date' => 'required|date|date_format:Y-m-d',
        ]);

        if($request->coupon == null){
           $data=array_merge($request->all(),['coupon'=>$this->generateCouponCode()]);
        }else{
            $data=$request->all();
        }

        Coupon::create($data);

        $this->flashAlert([
            'success' => ['msg' => __('messages.added')],
        ]);

        $request->flash();

        return back();
    }

    public function delete(Request $request)
    {

        if (Coupon::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }

    public function update(Request $request)
    {
        $id=$request->route('id');
        $this->validate($request, [
            'title' => 'required',
            'coupon' => "nullable|unique:coupons,id,$id",
            'amount' => 'required|integer',
            'limit' => 'required|integer',
            'expire_date' => 'required|date|date_format:Y-m-d',
        ]);

        if($request->coupon == null){
            $data=array_merge($request->all(),['coupon'=>$this->generateCouponCode()]);
         }else{
             $data=$request->all();
         }

        if (Coupon::find($id)->update($data)) {
            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

    public function generateCouponCode($length = 6) {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for($i = 0; $i < $length; ++$i) {
          $random = str_shuffle($chars);
          $code .= $random[0];
        }

        if(Coupon::where('coupon',$code)->first()){
          $code =  $this->generateCouponCode();
        }

        return $code;
      }

}
