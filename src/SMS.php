<?php

namespace Sms;

class SMS
{
    /**
     * @var string
     */
    protected $driver;

    protected $mode ;

    protected $class ;

    protected $config;


    /**
     * SmsService constructor.
     */
    public function __construct()
    {
        $this->config = Config::getInstance();

        $this->driver = $this->config->get('default');
        $this->class = $this->config->get('map.'.$this->driver);
    }

    /**
     * @param $key
     * @return $this
     */
    public function driver($key)
    {
        $this->driver = $key ;

        $this->class = $this->config->get('map.'.$this->driver);
        if( is_null($this->class) )
            die('This driver is not exist');

        return $this;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function text($text)
    {
        return $this->drive('text',[$text]);
    }

    /**
     * @param null $code
     * @return mixed
     */
    public function pattern($code = null)
    {
        $drive = $this->drive('pattern',[$code]);

        return $drive;
    }

    /**
     * @param $key
     * @param array $params
     * @return mixed
     */
    public function drive($key,$params = [])
    {
        $class = new $this->class;

        return call_user_func_array(array($class,$key),$params);
    }
}