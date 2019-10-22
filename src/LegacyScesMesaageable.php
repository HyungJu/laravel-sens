<?php


namespace NotificationChannels\Sens;


trait LegacyScesMesaageable
{

    public function tosms()
    {
        $this->payload['type'] = 'sms';
        return $this;
    }

    public function tolms()
    {
        $this->payload['type'] = 'lms';
        return $this;
    }

    public function forad()
    {
        $this->payload['contentType'] = 'AD';
        return $this;
    }

    public function forcommon()
    {
        $this->payload['contentType'] = 'COMM';
        return $this;
    }

    public function countrycode($code)
    {
        $this->payload['countryCode'] = $code;
        return $this;
    }

}