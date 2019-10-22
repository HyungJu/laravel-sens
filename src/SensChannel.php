<?php

namespace NotificationChannels\Sens;

use Illuminate\Notifications\Notification;

class SensChannel
{
    /**
     * @var Sens
     */
    protected $sens;

    /**
     * Channel constructor.
     *
     * @param Sens $sens
     */
    public function __construct(Sens $sens)
    {
        $this->sens = $sens;
    }


    /**
     * @param $notifiable
     * @param Notification $notification
     * @throws Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSens($notifiable);

        $this->sens->send($message);


    }
}
