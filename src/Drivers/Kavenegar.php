<?php

namespace Sms\Drivers;

use Illuminate\Support\Facades\Http;
use Sms\Config;
use Sms\SmsInterface;

class kavenegar implements SmsInterface
{
    protected $drive = 'kavenegar';

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

    public $token;

    protected $config;

    /**
     * farazsms constructor.
     */
    public function __construct()
    {
        $this->config = Config::getInstance();
        $this->username = $this->config->get('drivers.'.$this->drive.'.username');
        $this->password = $this->config->get('drivers.'.$this->drive.'.password');
        $this->token    = $this->config->get('drivers.'.$this->drive.'.token');
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
        if( $this->token )
            $token = $this->token;
        else
            $token = $this->password;

        $url = $this->url.'/'.$token.'/verify/lookup.json';
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
        if( is_null($this->token) )
            $token = $this->password;
        else
            $token = $this->token;

        $url = $this->url.'/'.$token.'/sms/send.json';
        $url .= '?receptor='.implode(",",$this->numbers);
        $url .= '&sender='.$this->from;
        $url .= '&message='.$text;

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}
