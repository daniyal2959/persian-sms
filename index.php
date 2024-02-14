<?php

use Sms\SMS;

require_once 'vendor/autoload.php';
$sms = new SMS();
$result = $sms->driver('kavenegar')->text('salam')->to(['09155627237'])->send();
print_r($result);
?>
