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

    protected $options;

    protected $credentials;

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

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options): Driver
    {
        if( $this->options == [] )
            $this->options = $options;
        else
            $this->options = array_merge($options, $this->options);

        return $this;
    }

    public function credential($credentials)
    {
        $this->credentials = $credentials;

        foreach ($this->credentials as $key => $value) {
            $this->options[$key] = $value;
        }

        return $this;
    }
}