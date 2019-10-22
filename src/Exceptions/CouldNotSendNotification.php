<?php

namespace NotificationChannels\Sens\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static($response);
    }

    public static function NCPTokenNotProvided($message)
    {
        return new static($message);
    }
}
