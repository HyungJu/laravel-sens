<?php

namespace NotificationChannels\Sens;

use GuzzleHttp\Client as HttpClient;
use NotificationChannels\Sens\Exceptions\CouldNotSendNotification;

class Sens
{
    /** @var HttpClient HTTP Client */
    private $http;

    /** @var null|string Tokens. */
    private $authKey;
    private $serviceSecret;
    private $serviceId;
    private $defaultFrom;

    /**
     * Sens constructor.
     * @param $authKey
     * @param $serviceSecret
     * @param $serviceId
     * @param HttpClient|null $httpClient
     */
    public function __construct($authKey, $serviceSecret, $serviceId, HttpClient $httpClient = null)
    {
        $this->authKey = $authKey;
        $this->serviceSecret = $serviceSecret;
        $this->serviceId = $serviceId;

        $this->http = $httpClient;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }


    public function send(SensMessage $message)
    {
        if (!isset($this->authKey) || !isset($this->serviceSecret) || !isset($this->serviceId)) {
            throw CouldNotSendNotification::NCPTokenNotProvided('Naver Cloud Platform Token Required');
        }

        if (!$message->getAttribute('from') && $this->getDefaultFrom()) {
            $message->from($this->getDefaultFrom());
        }

        $endPointUrl = 'https://api-sens.ncloud.com/v1/sms/services/' . $this->serviceId . '/messages';

        try {

            return $this->getHttpClient()->post($endPointUrl, [
                'headers' => array('Content-Type' => 'application/json', 'X-NCP-auth-key' => $this->authKey, 'X-NCP-service-secret' => $this->serviceSecret),
                'body' => json_encode($message->toArray())
            ]);


        } catch (\Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
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





