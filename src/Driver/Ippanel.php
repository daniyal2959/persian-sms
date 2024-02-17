<?php

namespace Sms\Driver;

use Sms\Driver;

class Ippanel extends Driver {
    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $numbers       = $this->numbers;
        $pattern_code  = $this->pattern_code;
        $username      = $this->options['username'];
        $password      = $this->options['password'];
        $from          = $this->options['from'];
        $to            = $numbers;
        $input_data    = $this->data;
        $url = $this->options['urlPattern']."?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($input_data));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        return $response;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $rcpt_nm = $this->numbers;
        $param = array
        (
            'uname'=> $this->options['username'] ,
            'pass'=> $this->options['password'],
            'from'=>$this->options['from'],
            'message'=>$text,
            'to'=>json_encode($rcpt_nm),
            'op'=>'send'
        );

        $handler = curl_init($this->options['urlNormal']);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($param));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}