<?php

namespace App\Custom\Notification;

use App\Services\SMS\SMS;
use App\Common\ValueObjects\Phone;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * @property App\Services\SMS\SMS $sms
     */
    protected $sms;

    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send(Phone $notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        // Send notification to the $notifiable instance...
        $this->sms->send($notifiable, $message);
    }
}
