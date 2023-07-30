<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MainEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $view;
    public $data;
    public $options;

    public function __construct($view, $data , $options = [])
    {
        $this->view = $view;
        $this->data = $data;
        $this->options = $options;
    }


    public function build()
    {
        $emailFrom = 'admin@saudi-captain2030.com';
        return $this->from($emailFrom)
                    ->view($this->view)
                    // ->text('aaaa') if we have view with plain text not html
                    ;

                    // Mail::send('util.password.email', [], function($message){
                    //    $message->to('tariksalahnet@hotmail.com', 'Al Feqh')->subject('Al Feqh');
                    //   $message->from('admin@al-feqh.com','Al-Feqh');

          // return $this->from($emailFrom)
          //             ->view($this->view)
          //             ->text('mails.demo_plain')
          //             ->with(
          //               [
          //                     'testVarOne' => '1',
          //                     'testVarTwo' => '2',
          //               ])
          //               ->attach(public_path('/images').'/demo.jpg', [
          //                       'as' => 'demo.jpg',
          //                       'mime' => 'image/jpeg',
          //               ]);



    }

}
