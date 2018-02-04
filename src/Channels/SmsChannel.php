<?php

namespace Elimuswift\SMS\Channels;

use Elimuswift\SMS\Facades\SMS;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $to = $message->content['to'];
        SMS::send(
            $message->content['smsView'],
            $message->content['data'],
            function ($sms) use ($to) {
                $sms->to($to);
            }
        );
    }

    //end send()
}//end class
