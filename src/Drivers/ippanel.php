<?php

namespace Sms\Drivers;

use Sms\Config;
use Sms\SmsInterface;

class ippanel implements SmsInterface
{
    protected $drive = 'ippanel';

    protected $method;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $url;

    protected $pattern_code;

    protected $to;

    protected $input_data;

    protected $numbers;

    protected $data;

    protected $text;

    protected $config;

    /**
     * farazsms constructor.
     */
    public function __construct()
    {
        $this->config = Config::getInstance();

        $this->username = $this->config->get('drivers.'.$this->drive.'.username');
        $this->password = $this->config->get('drivers.'.$this->drive.'.password');
        $this->from     = $this->config->get('drivers.'.$this->drive.'.from');
        $this->url      = $this->config->get('drivers.'.$this->drive.'.urlPattern');
    }

    /**
     * @return bool|mixed|string
     */
    public function send()
    {
        if ($this->method == 'pattern')
            $res = $this->sendPattern();
        else
            $res = $this->message($this->text);
        return $res;
    }

    /**
     * @param $text
     * @return $this|mixed
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param null $pattern_code
     * @return $this|mixed
     */
    public function pattern($pattern_code = null)
    {
        $this->method = 'pattern';
        if ($pattern_code)
            $this->pattern_code = $pattern_code;
        return $this;
    }

    /**
     * @param array $data
     * @return $this|mixed
     */
    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $from
     * @return $this|mixed
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param array $numbers
     * @return $this|mixed
     */
    public function to(array $numbers)
    {
        $this->numbers = $numbers;

        return $this;
    }

    /**
     * @return bool|mixed|string
     */
    public function sendPattern()
    {
        $numbers       = $this->numbers;
        $pattern_code  = $this->pattern_code;
        $username      = $this->username;
        $password      = $this->password;
        $from          = $this->from;
        $to            = $numbers;
        $input_data    = $this->data;

        $url = $this->url."?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($input_data));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function message($text)
    {
        $this->url   = $this->config->get('drivers.'.$this->drive.'.urlNormal');

        $rcpt_nm = $this->numbers;
        $param = array
        (
            'uname'=> $this->username ,
            'pass'=> $this->password,
            'from'=>$this->from,
            'message'=>$text,
            'to'=>json_encode($rcpt_nm),
            'op'=>'send'
        );

        $handler = curl_init($this->url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($param));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}