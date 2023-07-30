<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\Fcm;

use App\Notifications\CustomDbChannel;

class Main extends Notification implements ShouldQueue
{
    use Queueable;
    use Fcm;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        // $notifiable is the user
        // return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];

        // return ['mail','database','fcm'];
        return [CustomDbChannel::class,'fcm'];

    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
            'order_id' => $this->details['order_id'],
            'data' => [
                'title' => $this->details['title'],
                'body' => $this->details['body'],
            ],
            'order_status' => $this->details['status']
        ];
    }

    public function toFcm($notifiable)
    {
      if (!$notifiable->mobile_type) { return; }
      if (!$notifiable->fcm_token) { return; }
      $this->sendFcm( $notifiable->mobile_type, $notifiable->fcm_token, $this->details );
    }


    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->greeting($this->details['title'])
    //                 ->line($this->details['body'])
    //                 ->action($this->details['actionText'], $this->details['actionURL'])
    //                 ->line( __('Notification.end') );
    // }

}
