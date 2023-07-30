<?php

namespace App\Traits;
use App\User;
trait FcmNot
{

    function sendGCM($message, $token) {

    $url = 'https://fcm.googleapis.com/fcm/send';
    $notification = array('title' =>$message['title'] , 'body' => $message['body'], 'sound' => 'default', 'badge' => '1');
    $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
    
    $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high',"data"=>array(
    'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
    'content'=>$message
    ));
    
    $fields = json_encode($arrayToSend);
//     $fields = array (
//             'registration_ids' => array (
//                     $id
//             ),
//             'data' => array (
//                     "message" => $message
//             )
//     );
//     $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . "AAAAMUeX6DQ:APA91bGhnM1mgf-_FRFfmGgJcRbVsTS5k8Lib_7TqGwf4WrWHS1fvm_G416F7VvTOGDEdZe7QJvcERRwIVEa7H9QPrV9Csv3UyEJwQ5mtgh1akK7RU19RsHUQUwntymxagAlcQ_7ZRWx",
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    curl_close ( $ch );
    return $result;
    }
 
    public function sendGFCMWeb($userid,$msg){
        $user = User::find($userid);

        $token = $user->fcm_token;  
        $from = "AAAAz0lD1Kw:APA91bG--tIKkMEggIDzTAPv6wOHwueuXPGZrpEY8xqO-2fUdrbZSVjiipbzoI0k77Mqv_86EUir7z5jMywQnWyoM7PTgsAev0jUSxpLi2TH3y_3MH_hLQKNBjlVs8DKTcT72io2OGep";
        $message = array
              (
                "body" => $msg['body'],
                'title' =>$msg['title'],
                // 'receiver' => 'erw',
                'icon'  => "https://www.souq.appsjannah.com/storage/app/settings/Screenshot%202022-06-27%20174247.png",/*Default Icon*/
                'sound' => 'default'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    "notification" => $message
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
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
   
    
}