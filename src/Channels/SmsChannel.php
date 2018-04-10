<?php

namespace Elimuswift\SMS\Channels;

use Elimuswift\SMS\Facades\SMS;
use Illuminate\Notifications\Notification;
use Elimuswift\Notifications\SMSMessage;

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
        if (!$to = $notifiable->routeNotificationForSMS()) {
            return;
        }
        if (is_string($message)) {
            $message = new SMSMessage($message);
        }
        SMS::send(
            $message->content,
            $message->viewData,
            function ($sms) use ($to) {
                $sms->to($to);
            }
        );
    }

    //end send()
}//end class
