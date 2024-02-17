<?php

namespace Sms;

use Exception;

class SMS
{
    protected $driver ;

    protected $class ;

    /**
     * @param $key
     * @return $this
     */
    public function driver($key): Driver
    {
        $this->driver = $key ;

        $this->class = new ("Sms\\Driver\\" . ucfirst($this->driver));

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