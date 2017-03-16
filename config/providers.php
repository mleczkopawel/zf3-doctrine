<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:48
 */


return [
    'fb' => [
        'clientId' => 'id',
        'clientSecret' => 'secret',
        'redirectUri' => 'https://' . $_SERVER['HTTP_HOST'] . '/auth/callback/fb',
        'graphApiVersion' => 'v2.8'
    ],
    'google' => [
        'clientId' => '171739267348-a9iq068th25opq6itdgea63qj8c6326k.apps.googleusercontent.com',
        'clientSecret' => 'cCeql-sXixl__DL03YWTuU7x',
        'redirectUri' => 'https://' . $_SERVER['HTTP_HOST'] . '/auth/callback/google',
        'hostedDomain' => 'https://zf3d.pl'
    ]
];
