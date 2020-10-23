<?php

return [
    'autoload' => false,
    'hooks' => [
    ],
    'route' => [
        '/third.html$' => 'third/index/index',
        '/third/connect/[:platform]' => 'third/index/connect',
        '/third/callback/[:platform]' => 'third/index/callback',
        '/third/bind/[:platform]' => 'third/index/bind',
        '/third/unbind/[:platform]' => 'third/index/unbind',
    ],
    'service' => [
    ],
];