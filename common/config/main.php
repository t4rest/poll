<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => 'C3ftwR94zDmcYFuURmXnwHaDS',
                    'consumerSecret' => '0Z4ihUdeBRFM5zb6eRQXg0oKXjaEwaw0cl1wP5PHHUjFslzsvw',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '127796407811537',
                    'clientSecret' => '8ee4d7f62bead50025462ced14accd8a',
                ],
            ],
        ],


    ]
];
