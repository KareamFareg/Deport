<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MainNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $user_name;
    public $type;
    public $link;
    public $message;
    // public $created_at;

    public function __construct($user_id, $user_name, $type, $link, $message)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->type = $type;
        $this->link = $link;
        $this->message = $message;
        // $this->created_at = UtilHelper::currentDate();
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
