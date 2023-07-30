<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait TawseelDriver
{
    public function CreatDriverInTawseel($request , $driver){
       
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Driver/create', [
            "credential" =>[
             "companyName"=>"dport",
             "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
              "driver"=> [
                             "identityTypeId"=> $request->identityTypeId,
                             "idNumber"=> $request->idNumber,
                             "dateOfBirth"=> $request->dateOfBirth,
                             "registrationDate"=> gmdate('Y-m-d H:i:s', strtotime($driver->created_at)),
                             "mobile"=> $driver->phone,
                             "regionId"=> $request->regionId,
                             "carTypeId"=> $request->carTypeId,
                             "cityId"=> $request->cityId,
                             "carNumber"=> $request->carNumber,
                             "vehicleSequenceNumber"=> $request->vehicleSequenceNumber
                       ]
              ])->throw()->json();
              if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['TawseelErrorMessage'] = $TawseelResponse['errorCodes'];
                    return   $data;
            }else{
                        $data ['tawseelStatus']  = true;
                        $data['idNumber']        =  $TawseelResponse['data']['idNumber'];
                        $data['identityTypeId']  =  $TawseelResponse['data']['identityTypeId'];
                        $data['refrenceCode']    =  $TawseelResponse['data']['refrenceCode'];
                            return   $data;
            }     
    }
    public function UpdateDriverInTawseel($request , $driver){
          
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Driver/edit', [
            "credential" =>[
             "companyName"=>"dport",
             "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
              "driver"=> [
                            "refrenceCode"=> $driver->refrenceCode ,
                            "identityTypeId"=> $driver->identityTypeId,           
                            "idNumber"=> $driver->idNumber,
                            "dateOfBirth"=> $request->dateOfBirth,
                            "registrationDate"=> gmdate('Y-m-d H:i:s', strtotime($driver->created_at)),
                            "mobile"=> $driver->phone,
                            "regionId"=> $request->regionId,
                            "carTypeId"=> $request->carTypeId,
                            "cityId"=> $request->cityId,
                            "carNumber"=> $request->carNumber,
                            "vehicleSequenceNumber"=> $request->vehicleSequenceNumber
                       ]
              ])->throw()->json();
    
            if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['TawseelErrorMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
                    return   $data;
            }else{
                        $data ['tawseelStatus']        = true;
                        $data ['tawseel']  = $TawseelResponse['data'];
                            return   $data;
            }     
     }     
     public function getDriverInTawseel($id){
          
        $TawseelResponse = Http::post('https://demo-apitawseel.naql.sa/api/Driver/get', [
            "credential" =>[
                     "companyName"=>"dport",
                     "password"=>"HGtP5kQWXx0fTpNa5L8qu10qeK3STnpoHkExKfBAaMbMoKO1aET64GWxySiPWpFz"
                ],
              "idNumber"=>$id
          ])->throw()->json();
    
            if($TawseelResponse['status'] == false){
                $data ['tawseelStatus']        = false;
                $data['TawseelErrorMessage'] = $this ->getErrorCode($TawseelResponse['errorCodes'][0]);
                    return   $data;
            }else{
                        $data['tawseelStatus'] = true;
                        $data ['tawseel']  = $TawseelResponse['data'];
                            return   $data;
            }     
     }     
}
