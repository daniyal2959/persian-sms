<?php

namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;
use Sms\Http;

class Ippanel extends Driver implements IDriver {

    const BASE_URL = 'https://api2.ippanel.com/api/v1/';

    public function __construct()
    {
        $this->client = new Http(self::BASE_URL, 30, []);
    }

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $response = $this->client->post('/sms/pattern/normal/send', [
            'code' => $this->pattern_code,
            'sender' => $this->from,
            'recipient' => $this->numbers[0],
            'variable' => $this->data
        ]);
        return $this->response($response);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text){
        $response = $this->client->post('/sms/send/webservice/single', [
            'recipient' => $this->numbers,
            'sender' => $this->from,
            'message' => $text
        ]);
        return $this->response($response);
    }

    public function setCredential()
    {
        $this->client->headers[] = "apiKey: " . $this->apiKey;
    }
}