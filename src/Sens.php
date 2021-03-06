<?php

namespace NotificationChannels\Sens;

use GuzzleHttp\Client as HttpClient;

class Sens
{
    private $http;
    private $authKey;
    private $serviceSecret;
    private $serviceId;
    private $defaultFrom;


    public function __construct(string $authKey, string $serviceSecret, string $serviceId)
    {
        $this->authKey = $authKey;
        $this->serviceSecret = $serviceSecret;
        $this->serviceId = $serviceId;
        $this->http = new HttpClient();
    }


    public function send(SensMessage $message)
    {
        if (!$message->getAttribute('from') && $this->getDefaultFrom()) {
            $message->from($this->getDefaultFrom());
        }

        $endPointUrl = 'https://api-sens.ncloud.com/v1/sms/services/' . $this->serviceId . '/messages';

        return $this->http->post($endPointUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-NCP-auth-key' => $this->authKey,
                'X-NCP-service-secret' => $this->serviceSecret
            ],
            'body' => json_encode($message->toArray())
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
}





