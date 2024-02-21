<?php

namespace Sms\Driver;

use Sms\Contract\IDriver;
use Sms\Driver;

class Ippanel extends Driver implements IDriver {

    const NORMAL_URL = 'https://ippanel.com/services.jspd';

    const PATTERN_URL = 'https://ippanel.com/patterns/pattern';

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $username = $this->credentials['username'];
        $password = $this->credentials['password'];
        $from = $this->from;
        $pattern_code = $this->pattern_code;
        $to = $this->numbers;
        $input_data = $this->data;
        $url = self::PATTERN_URL . "?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $param = array
        (
            'uname'=> $this->credentials['username'],
            'pass'=> $this->credentials['password'],
            'from'=> $this->from,
            'message'=> $text,
            'to'=>json_encode($this->numbers),
            'op'=>'send'
        );

        $handler = curl_init(self::NORMAL_URL);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}