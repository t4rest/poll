<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;port=5432;dbname=edvice',
            'username' => 'postgres',
            'password' => '123',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'twitter' => [
                    'class' => 'common\clients\Twitter',
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => 'C3ftwR94zDmcYFuURmXnwHaDS',
                    'consumerSecret' => '0Z4ihUdeBRFM5zb6eRQXg0oKXjaEwaw0cl1wP5PHHUjFslzsvw',
                ],
                'facebook' => [
                    'class' => 'common\clients\Facebook',
                    'clientId' => '127796407811537',
                    'clientSecret' => '8ee4d7f62bead50025462ced14accd8a',
                ],
            ],
        ],
    ],
];
