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
            'schemaMap' => [
                'pgsql'=> 'tigrov\pgsql\Schema',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        //http://poll.s3-website.eu-central-1.amazonaws.com
        's3' => [
            'class' => 'frostealth\yii2\aws\s3\Service',
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => 'AKIAIJ3VM7M3G4OHDR5A',
                'secret' => '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',
            ],
            'region' => 'eu-central-1',
            'defaultBucket' => 'polltest',
            'defaultAcl' => 'public-read',
        ],
    ],
];

