<?php

namespace App\Traits;

trait Fcm
{
    public function sendFcm($mobile_type, $fcm_token, $data)
    {
        $tokens = [];
        $apns_ids = [];
        $responseData = [];
        $id = "861384216749";
        // $data= $request->all();

        // for Android
        // foreach ($FCMTokenData as $key => $value) {
        //   $tokens[] = $value->token;
        // }
        // define('YOUR_SERVER_KEY', 'YOUR_SERVER_KEY' );

        // $msg = array (
        //   'message'  => 'body Test from mandoob',
        //   'title' => 'Notification',
        //   // 'subtitle' => 'This is a subtitle',
        // );

        // android
        if ($mobile_type == 'android') {
            $fields = array(
                'to' => $fcm_token,
                'data' => $data,
                // 'registration_ids'  => $data->fcm_token,
                // 'content_available' => true,
                // 'priority' => 'high',
                // 'notification'  => $msg,
                // 'time_to_live' => '2419200'
            );
        }

        // ios
        if ($mobile_type == 'ios') {
            $title = $data['title'];
            $body = $data['body'];
            $order = isset($data['order']) ?? '';
            $type = isset($data['type']) ?? '';

            $notification = array('title' => $title, 'body' => $body,'order' => $order , 'type' => $type , 'sound' => 'default', 'badge' => '1');

            $fields = array(
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
                'to' => $fcm_token,
                'notification' => $notification,
               'id'=> $id,
               
                // 'registration_ids'  => $data->fcm_token,
                // 'content_available' => true,
                'priority' => 'high',
                // 'notification'  => $msg,
                // 'time_to_live' => '2419200'
            );
        }
        // AIzaSyDfuTRkLaNvyWxQXQtGaLWN9LeqZm_ZNt4
        // 'AAAAHuFhNFU:APA91bGku4S335KymqLgV_iVQZxkv0z9Bsx7qn6L833AQu6Emyxn_aoqD20AV1q2QDglBtPQWLTPPaAm9cE9BH2Vur63whNzmLaiWqjq7SI4960gbGlE0G8nY5N_lN2eyhQA70FilU25',
        $headers = array(
            'Authorization: key=' . 'AAAAMUeX6DQ:APA91bGhnM1mgf-_FRFfmGgJcRbVsTS5k8Lib_7TqGwf4WrWHS1fvm_G416F7VvTOGDEdZe7QJvcERRwIVEa7H9QPrV9Csv3UyEJwQ5mtgh1akK7RU19RsHUQUwntymxagAlcQ_7ZRWx',
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4); // false
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        if ($result === false) {
            // return curl_error($ch);
            return false;
        }

        $result = json_decode($result, true);
        // $responseData['android'] = [
        //   "result" =>$result
        // ];
        $responseData = [
            "result" => $result,
        ];
        curl_close($ch);

        // for IOS
        // if ($FCMTokenData = $this->fcmToken->whereIn('user_id',$users)->where('apns_id','!=',null)->select('apns_id')->get()) {
        //     foreach ($FCMTokenData as $key => $value)
        //     {
        //     $apns_ids[] = $value->apns_id;
        //     }
        //     $url = "https://fcm.googleapis.com/fcm/send";
        //     $serverKey = 'YOUR_SERVER_KEY';
        //     $title = "Thsi is title";
        //     $body = 'This is body';
        //     $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
        //     $arrayToSend = array('registration_ids' => $apns_ids, 'notification' => $notification,'priority'=>'high');
        //     $json = json_encode($arrayToSend);
        //     $headers = array();
        //     $headers[] = 'Content-Type: application/json';
        //     $headers[] = 'Authorization: key='. $serverKey;
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     //Send the request
        //     $result = curl_exec($ch);
        //     if ($result === FALSE) {
        //       die('FCM Send Error: ' . curl_error($ch));
        //     }
        //     $result = json_decode($result,true);
        //     $responseData['ios'] =[
        //     "result" =>$result
        //     ];
        //     //Close request
        //     curl_close($ch);
        // }

        return $responseData;
    }

    public function sendFcmGroup($group, $data)
    {

        $responseData = [];
        $headers = array(
            'Authorization: key=' . 'AAAAMUeX6DQ:APA91bGhnM1mgf-_FRFfmGgJcRbVsTS5k8Lib_7TqGwf4WrWHS1fvm_G416F7VvTOGDEdZe7QJvcERRwIVEa7H9QPrV9Csv3UyEJwQ5mtgh1akK7RU19RsHUQUwntymxagAlcQ_7ZRWx',
            'Content-Type: application/json',
        );

        $title = $data['title'];
        $body = $data['body'];
        $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');

        $fields = array(
            'to' => '/' . 'topics/' . $group.'_android',
            'data' => $data,
            // 'registration_ids'  => $data->fcm_token,
            // 'content_available' => true,
            'priority' => 'high',
            // 'notification'  => $msg,
            // 'time_to_live' => '2419200'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result =  curl_exec($ch);
        curl_close($ch);
        //   $responseData = [
        //     "result" => $result,
        // ];
        //   return $responseData;


        $fields = array(
            'to' => '/' . 'topics/' . $group.'_ios2',
            'notification' => $notification,
            // 'registration_ids'  => $data->fcm_token,
            // 'content_available' => true,
            'priority' => 'high',
            // 'notification'  => $msg,
            // 'time_to_live' => '2419200'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result =  curl_exec($ch);
        curl_close($ch);

        return true;
    }

    public function sendFcmWeb()
    {

        $headers = array(
            'Authorization: Bearer ' . 'BK5tYw-JZrtcEO8oUN_fr-Hpst6IVQkCNWOdwYhbFIj9R75fk3lpov4lcjJvQKFFi5B_ES_h0zaHkggZPZ7wwSM',
            'Content-Type: application/json',
        );

        $fields = ["message" => [
            "notification" => [
                "title" => "FCM Message",
                "body" => "This is a message from FCM",
            ],
            "webpush" => [
                "headers" => [
                    "Urgency" => "high",
                ],
                "notification" => [
                    "body" => "This is a message from FCM to web",
                    "requireInteraction" => "true",
                    "badge" => "/badge-icon.png",
                ],
            ],
        ],
            "token" => "cjSAzc3tkHQ:APA91bH8L-q_aP05GvEPQ0LSkVzVwi4kOq3xKeTQ08ZtEvorgufH1l1OigJZ3ZKBkIlCZPLwzOSAZBpqlBFz1CDXwYPVjrH_073T2udC15-B-FsFneVgQIc8EveKAmXmoFXl9fPcVUmW",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/souq-pay/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4); // false
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        if ($result === false) {
            return curl_error($ch);
        }

        $result = json_decode($result, true);
        $responseData['web'] = [
            "result" => $result,
        ];
        curl_close($ch);

        return $responseData;

        //   curl -X POST -H "Authorization: Bearer ya29.ElqKBGN2Ri_Uz...PbJ_uNasm" -H "Content-Type: application/json" -d '{
        //   "message": {
        //     "notification": {
        //       "title": "FCM Message",
        //       "body": "This is a message from FCM"
        //     },
        //     "webpush": {
        //       "headers": {
        //         "Urgency": "high"
        //       },
        //       "notification": {
        //         "body": "This is a message from FCM to web",
        //         "requireInteraction": "true",
        //         "badge": "/badge-icon.png"
        //       }
        //     }
        //   },
        //   "token": "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ3P1..."
        //   }
        // }' "https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send"

    }

}
