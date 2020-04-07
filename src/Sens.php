<?php

namespace NotificationChannels\Sens;

use GuzzleHttp\Client as HttpClient;

class Sens
{
    private $http;
    private $iamAccessKey;
    private $secretKey;
    private $serviceId;
    private $defaultFrom;
    private $defaultTimezone;


    public function __construct(string $iamAccessKey, string $secretKey, string $serviceId)
    {
        $this->iamAccessKey = $iamAccessKey;
        $this->secretKey = $secretKey;
        $this->serviceId = $serviceId;
        $this->http = new HttpClient();
    }


    public function send(SensMessage $message)
    {
        if (!$message->getAttribute('from') && $this->getDefaultFrom())
        {
            $message->from($this->getDefaultFrom());
        }

        if($this->getDefaultTimezone())
        {
            date_default_timezone_set($this->getDefaultTimezone());
        }

        $endPointUrl = 'https://sens.apigw.ntruss.com/sms/v2/services/' . $this->serviceId . '/messages';


        return $this->http->post($endPointUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-ncp-apigw-timestamp' => time(),
                'x-ncp-iam-access-key' => $this->iamAccessKey,
                'x-ncp-apigw-signature-v2' => $message->generateSignature($this->secretKey)
            ],
            'body' => $message->toJson()
        ]);
    }


    public function setDefaultFrom($from)
    {
        $this->defaultFrom = $from;
        return $this;
    }

    public function getDefaultFrom()
    {
        return $this->defaultFrom;
    }

    public function setDefaultTimezone($timezone)
    {
        $this->defaultTimezone = $timezone;
        return $this;
    }

    public function getDefaultTimezone()
    {
        return $this->defaultTimezone;
    }
}





