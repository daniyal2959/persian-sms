<?php

namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;

class Kavenegar extends Driver implements IDriver
{
    const NORMAL_URL = 'https://api.kavenegar.com/v1';

    const PATTERN_URL = 'https://api.kavenegar.com/v1';

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $patterns = [];
        $url = self::PATTERN_URL.'/'.$this->credentials['token'].'/verify/lookup.json?';

        foreach ($this->data as $patternKey => $patternValue ){
            $patterns[$patternKey] = $patternValue;
        }

        $data = [
            'receptor' => $this->numbers[0],
            'template' => $this->pattern_code
        ];
        $data = array_merge($data, $patterns);
        $url .= http_build_query($data);

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $responseString = curl_exec($handler);
        return $this->response($responseString);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $url = self::NORMAL_URL.'/'.$this->credentials['token'].'/sms/send.json?';

        $data = [
            'receptor' => implode(",",$this->numbers),
            'sender' => $this->from,
            'message' => $text
        ];
        $url .= http_build_query($data);

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $responseString = curl_exec($handler);
        return $this->response($responseString);
    }
}