<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;
use DB;
use App\ProfileMeta;
use App\PrivacyPolicy;
use App\Faq;
use App\Guidelines;

class testController extends Controller
{
    public function index(){
        return view('firbase');
    }
    public function saveToken(Request $request){
 
        // $user = User::find(Auth::id());
        $user = User::find(Auth::id());
    
        $user->fcm_token = $request->token;
        $user->save();
        return $user;
    }
    function test($userid){
        $user = User::find($userid);

        $token = $user->fcm_token;  
        $from = "AAAAz0lD1Kw:APA91bG--tIKkMEggIDzTAPv6wOHwueuXPGZrpEY8xqO-2fUdrbZSVjiipbzoI0k77Mqv_86EUir7z5jMywQnWyoM7PTgsAev0jUSxpLi2TH3y_3MH_hLQKNBjlVs8DKTcT72io2OGep";
        $msg = array
              (
                "body" => "Testing Testing",
                'title' => "Hi, From Raj",
                // 'receiver' => 'erw',
                'icon'  => "https://www.souq.appsjannah.com/storage/app/settings/Screenshot%202022-06-27%20174247.png",/*Default Icon*/
                'sound' => 'default'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    "notification" => [
                        "title"=> "Notification Title",
                        "body"=> "Notification Body xx",
                        "icon"=>"https://image.flaticon.com/icons/png/512/270/270014.png",
                        "sound"=>"default"
                       ]
                );

        $headers = array
                (
                    'Content-Type: application/json',
                    'Authorization: key=' . $from
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    }
}