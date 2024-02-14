<?php

return [
    'default' => 'ippanel',

    'drivers' => [
        'ippanel' => [
            'username'    => 'username',
            'password'    => 'password',
            'urlPattern'  => 'https://ippanel.com/patterns/pattern',
            'urlNormal'   => 'https://ippanel.com/services.jspd',
            'from'        => '+983000505',
        ],
        'farazsms' => [
            'username'    => 'username',
            'password'    => 'password',
            'urlPattern'  => 'https://ippanel.com/patterns/pattern',
            'urlNormal'   => 'https://ippanel.com/services.jspd',
            'from'        => '+983000505',
        ],
        'kavenegar' => [
            'username'    => 'username',
            'password'    => 'password',
            'token'       => '5A53486367786D436C342B5059785364504350455A6277415668553270524C62724D634A70722F775A6E513D',
            'urlPattern'  => 'https://api.kavenegar.com/v1',
            'urlNormal'   => 'https://api.kavenegar.com/v1',
            'from'        => '2000500666',
        ],
        'smsir' => [
            'apiKey'      => '',
            'urlPattern'  => 'https://api.sms.ir/v1/send/verify',
            'urlNormal'   => 'https://api.sms.ir/v1/send/bulk',
            'from'        => '+983000505',
        ],
    ],

    'map' => [
        'ippanel'       => \Sms\Drivers\ippanel::class,
        'kavenegar'     => \Sms\Drivers\Kavenegar::class,
    ]
];