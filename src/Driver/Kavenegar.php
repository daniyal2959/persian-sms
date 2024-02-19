<?php

namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;

class Kavenegar extends Driver implements IDriver
{
    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $patterns = [];
        $url = $this->options['urlPattern'].'/'.$this->credentials['token'].'/verify/lookup.json?';

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
        return curl_exec($handler);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $url = $this->options['urlNormal'].'/'.$this->credentials['token'].'/sms/send.json?';

        $data = [
            'receptor' => implode(",",$this->numbers),
            'sender' => $this->options['from'],
            'message' => $text
        ];
        $url .= http_build_query($data);

        $handler = curl_init($url);
        return curl_exec($handler);
    }
}