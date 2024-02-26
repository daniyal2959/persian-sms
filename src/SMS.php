<?php

namespace Sms;

use Exception;

class SMS
{
    protected string $driver ;

    protected Driver $class ;

    public function __construct(
        public string $apiKey
    ){}

    /**
     * @param $key
     * @return Driver
     * @throws Exception
     */
    public function driver($key): Driver
    {
        $this->driver = $key ;

        $this->class = new ("Sms\\Driver\\" . ucfirst($this->driver));
        $this->class->apiKey = $this->apiKey;
        $this->class->setCredential();

        return $this->class;
    }

    /**
     * @throws Exception
     */
    private function checkException(){
        if( empty($this->driver) )
            throw new Exception('The driver is empty');
    }
}