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
        $url = $this->options['urlPattern'].'/'.$this->credentials['token'].'/verify/lookup.json';
        $url .= '?receptor='.$this->numbers[0];
        foreach ($this->data as $patternKey => $patternValue ){
            $url .= '&'.$patternKey.'='.$patternValue;
        }
        $url .= '&template='.$this->pattern_code;

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $url = $this->options['urlNormal'].'/'.$this->credentials['token'].'/sms/send.json';
        $url .= '?receptor='.implode(",",$this->numbers);
        $url .= '&sender='.$this->options['from'];
        $url .= '&message='.$text;

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}