<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;
use App\User;

trait TawseelOrder
{
//TAWSEEL ORDER
    public function CreateOrderInTawseel($request,$order){
        if($order->shop_name == null){
            $order->shop_name= "unknown";
        }
        $user = User::find($order->user_id);
        if($user->region_id == null){
            $user->region_id = "Nap4gA1tyeY=";
        }
        if($user->city_id == null){
            $user->city_id = "Nap4gA1tyeY=";
        }
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Order/create', [
            "credential" =>[
             "companyName"=>"dport",
             "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
             "order"=> [
             "orderNumber"  => $order->id,
             "authorityId"  => "NV25GlPuOnQ=",
             "deliveryTime" => gmdate('Y-m-d H:i:s', strtotime($order->created_at)),
             "regionId"     => $user->region_id,
             "cityId"       => $user->city_id,
             "coordinates"  => $order->destination_lat .",". $order->destination_lng,
             "storetName"   => $order->shop_name,
             "storeLocation"=> $order->source_lat .",". $order->source_lng,
             "categoryId"   =>"Nap4gA1tyeY=",
             "orderDate"    => gmdate("Y-m-d\TH:i:s\Z", time())
            ]
        ])->throw()->json();
   
            if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['tawseelMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
                    return   $data;
       } else{
                $data ['tawseelStatus']        = true;
                $data['refrenceCode'] =  $TawseelResponse['data']['referenceCode'];
                    return   $data;
       } 
    }
    public function AcceptOrderInTawseel( $refrenceCode ){

        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Order/accept', [
            "credential" =>[
            "companyName"=>"dport",
            "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
            "referenceCode"=> $refrenceCode,
            "acceptanceDateTime"=> gmdate("Y-m-d\TH:i:s\Z", time()),

            ])->throw()->json();
        if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['tawseelMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
                    return   $data;
       }
       else{
                $data ['tawseelStatus'] = true;
                $data ['response']      =  $TawseelResponse;
                    return   $data;
        }

    }
    
    public function CancelOrderInTawseel( $refrenceCode){

        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Order/cancel', [
            "credential" =>[
            "companyName"=>"dport",
            "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
            "orderId"=> $refrenceCode,
            "cancelationReasonId"=> "NV25GlPuOnQ="

            ])->throw()->json();
        if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['tawseelMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
                    return   $data;
       }
       else{
                $data ['tawseelStatus'] = true;
                $data ['response']      =  $TawseelResponse;
                    return   $data;
        }

    }
    
    public function ExecuteOrderInTawseel($request , $order){
        //excute order  in Tawseel
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Order/execute', [
            "credential" =>[
            "companyName"=>"dport",
            "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
                "orderExecutionData" => [
                    "referenceCode"   => $order->refrenceCode,
                    "executionTime"   =>gmdate("Y-m-d\TH:i:s\Z", time()),
                    "paymentMethodId" => 'NV25GlPuOnQ=',
                    "price"           => $order->total
                    ]

        ])->throw()->json();
    
    if($TawseelResponse['status'] == false){
        $data ['tawseelStatus']        = false;
        $data['tawseelMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
            return   $data;
    }
    else{
            $data ['tawseelStatus'] = true;
            $data ['response']      =  $TawseelResponse;
                return   $data;
    }
}
    public function AssignDriverToOrderInTawseel($refrenceCode , $idNumber){
   //assign driver to order in Tawseel
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Order/assign-driver-to-order', [
            "credential" =>[
            "companyName"=>"dport",
            "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
            "referenceCode" => $refrenceCode,
            "idNumber"      => $idNumber

        ])->throw()->json();
    
    if($TawseelResponse['status'] == false){
        $data ['tawseelStatus']        = false;
        $data['tawseelMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
            return   $data;
    }
    else{
            $data ['tawseelStatus'] = true;
            $data ['response']      =  $TawseelResponse;
                return   $data;
    }
  }
}
