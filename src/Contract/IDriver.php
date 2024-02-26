<?php

namespace Sms\Contract;

interface IDriver{

    public function sendPattern();

    public function message($text);

    public function setCredential();
}