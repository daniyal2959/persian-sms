<?php

namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;
use Sms\Http;

class Kavenegar extends Driver implements IDriver
{
    const BASE_URL = 'https://api.kavenegar.com/v1';

    public function __construct()
    {
        $this->client = new Http(self::BASE_URL, 30, []);
    }

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $response = $this->client->get('/verify/lookup.json', [
            'receptor' => $this->numbers[0],
            'template' => $this->pattern_code,
        ]);
        return $this->response($response);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $response = $this->client->get('/sms/send.json', [
            'receptor' => implode(",",$this->numbers),
            'sender' => $this->from,
            'message' => $text
        ]);

        return $this->response($response);
    }

    public function setCredential()
    {
        $this->client->urlBase = self::BASE_URL . '/' . $this->apiKey . '/';
    }
}