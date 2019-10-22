<?php

namespace NotificationChannels\Sens;

use GuzzleHttp\Client as HttpClient;
use NotificationChannels\Sens\Exceptions\CouldNotSendNotification;

class Sens
{
    /** @var HttpClient HTTP Client */
    protected $http;

    /** @var null|string Tokens. */
    protected $authkey = null;
    protected $service_secret = null;
    protected $service_id = null;


    /**
     * Sens constructor.
     * @param $authkey
     * @param $service_secret
     * @param $service_id
     * @param HttpClient|null $httpClient
     */
    public function __construct($authkey, $service_secret, $service_id, HttpClient $httpClient = null)
    {
        $this->authkey = $authkey;
        $this->service_secret = $service_secret;
        $this->service_id = $service_id;

        $this->http = $httpClient;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }


    public function sendMessage($params)
    {
        if (!isset($this->authkey) || !isset($this->service_secret) || !isset($this->service_id)) {
            throw CouldNotSendNotification::NCPTokenNotProvided('Naver Cloud Platform Token Required');
        }

        $endPointUrl = 'https://api-sens.ncloud.com/v1/sms/services/' . $this->service_id . '/messages';

        try {

            return $this->httpClient()->post($endPointUrl, [
                'headers' => array('Content-Type' => 'application/json', 'X-NCP-auth-key' => $this->authkey, 'X-NCP-service-secret' => $this->service_secret),
                'body' => json_encode($params)
            ]);


        } catch (\Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}





