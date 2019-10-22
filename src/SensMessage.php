<?php

namespace NotificationChannels\Sens;

class SensMessage
{

    use LegacyScesMesaageable;

    public $payload = [];


    /**
     * @param string $content
     * @return SensMessage
     */
    public static function create($content = '')
    {
        return (new static())->content($content);
    }


    public function to($number)
    {
        $this->payload['to'] = array($number);
        return $this;
    }

    public function from(string $number)
    {
        $this->payload['from'] = $number;
        return $this;
    }

    public function getAttribute(string $key)
    {
        return $this->payload[$key] ?? null;
    }

    public function toSMS()
    {
        $this->payload['type'] = 'sms';
        return $this;
    }

    public function toLMS()
    {
        $this->payload['type'] = 'lms';
        return $this;
    }

    public function forAD()
    {
        $this->payload['contentType'] = 'AD';
        return $this;
    }

    public function forCommon()
    {
        $this->payload['contentType'] = 'COMM';
        return $this;
    }

    public function countryCode($code)
    {
        $this->payload['countryCode'] = $code;
        return $this;
    }

    public function content($content)
    {
        $this->payload['content'] = $content;
        return $this;
    }

    public function subject($subject)
    {
        $this->payload['subject'] = $subject;
        $this->payload['type'] = 'lms';
        return $this;
    }

    public function toArray()
    {
        return $this->payload;
    }
}
