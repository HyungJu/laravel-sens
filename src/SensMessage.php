<?php

namespace NotificationChannels\Sens;

use Illuminate\Support\Arr;

class SensMessage
{
     public $payload = [];


    public static function create($content = '')
    {
        return new static($content);
    }

    

    public function to($number)
    {
        $this->payload['to'] = $number;
        return $this;
    }
   public function tosms()
    {
        $this->payload['type'] = 'sms';
        return $this;
    } public function tolms()
    {
        $this->payload['type'] = 'lms';
        return $this;
    }
  public function forad()
    {
        $this->payload['contenttype'] = 'AD';
        return $this;
    }
 public function forcommon()
    {
        $this->payload['contenttype'] = 'COMM';
        return $this;
    }
   public function countrycode($code)
    {
        $this->payload['countrycode'] = $code;
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
