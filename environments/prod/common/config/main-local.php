<?php

$host = $port = $username = $password = $dbname = '';
$url = parse_url(getenv("DATABASE_URL"));
if (isset($url["host"]) && isset($url["user"]) && isset($url["pass"]) && isset($url["path"])) {
    $host = $url["host"];
    $port = $url["port"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);
}


return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
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
