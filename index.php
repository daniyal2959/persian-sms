<?php

use Sms\SMS;

require_once 'vendor/autoload.php';

$sms = new SMS();
$result = $sms->driver('kavenegar')
                ->text('salam')
                ->to(['09155627237'])
                ->options([
                    'from' => '2000500666',
                    'urlPattern' => 'https://api.kavenegar.com/v1',
                    'urlNormal'  => 'https://api.kavenegar.com/v1',
                ])
                ->credential([
                    'token' => '5A53486367786D436C342B5059785364504350455A6277415668553270524C62724D634A70722F775A6E513D'
                ])
                ->send();
print_r($result);