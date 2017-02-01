<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:48
 */



return [
    'fb' => [
        'clientId' => '1143277982455317',
        'clientSecret' => '50e5a58909bba2d062525649954aa37a',
        'redirectUri' => 'https://' . $_SERVER['HTTP_HOST'] . '/' . LOCALE . '/auth/callback/fb',
        'graphApiVersion' => 'v2.8'
    ],
    'google' => [
        'clientId' => '171739267348-a9iq068th25opq6itdgea63qj8c6326k.apps.googleusercontent.com',
        'clientSecret' => 'cCeql-sXixl__DL03YWTuU7x',
        'redirectUri' => 'https://' . $_SERVER['HTTP_HOST'] . '/' . LOCALE . '/auth/callback/google',
        'hostedDomain' => 'https://zf3d.pl'
    ]
];