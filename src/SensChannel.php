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
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSens($notifiable);

        $params = $message->toArray();
        $this->sens->sendMessage($params);


    }
}
