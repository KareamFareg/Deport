<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomDbChannel
{

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);

    return $notifiable->routeNotificationFor('database')->create([
        // 'id' => $notification->id, // this will generate key of string
        'order_id' => $data['order_id'], //<-- comes from toDatabase() Method below
        'order_status' => $data['order_status'],
        'data' => $data,
        'read_at' => null,
        'user_id' => $data['user_id'],
    ]);
  }

}
