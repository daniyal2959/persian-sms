<?php

namespace Sms;

abstract class Driver
{
    protected $method;

    protected $from;

    protected $pattern_code;

    protected $numbers;

    protected $data;

    protected $text;

    protected $credentials;

    protected $asJson;

    /**
     * @return bool|mixed|string
     */
    public function send($asJson = false)
    {
        $this->asJson = $asJson;

        if ($this->method == 'pattern')
            $res = $this->sendPattern();
        else
            $res = $this->message($this->text);
        return $res;
    }

    /**
     * @param $text
     * @return $this
     */
    public function text($text): Driver
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param null $pattern_code
     * @return $this
     */
    public function pattern($pattern_code = null): Driver
    {
        $this->method = 'pattern';
        if ($pattern_code)
            $this->pattern_code = $pattern_code;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function data(array $data): Driver
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from): Driver
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param array $numbers
     * @return $this
     */
    public function to(array $numbers): Driver
    {
        $this->numbers = $numbers;

        return $this;
    }

    public function credential($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    protected function response($values){
        if( $this->asJson )
            return json_decode($values);
        return $values;
    }
}