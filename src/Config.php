<?php

namespace Sms;

class Config
{
    private static $_instance = null;

    public $settings;

    private function  __clone() { }

    public static function getInstance()
    {
        if( !is_object(self::$_instance) )  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Config();
        return self::$_instance;
    }

    private function  __construct() { }

    private function load(){
        return require_once('configs/sms-settings.php');
    }

    private function extract($direction){
        return explode('.', $direction);
    }

    /**
     * @param string $direction
     * @return array
     */
    public function get($direction)
    {
        if( !$this->settings )
            $this->settings = $this->load();

        $extracted = $this->extract($direction);
        $result = $this->settings;
        foreach ($extracted as $item) {
            if( in_array($item, array_keys($result)) )
                $result = $result[$item];
            else
                $result = null;
        }
        return $result;
    }
}