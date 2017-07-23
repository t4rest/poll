<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [


        /**
         * main page
         */
        '' => 'main/site/index',

        /**
         * error action rules
         */
        'error' => 'main/site/error',


        /**
         * site controller
         */
        'site/<_a:[\w\-]+>' => 'main/site/<_a>',

        'GET api/country' => 'api/country/index',


        'GET api/user' => 'api/user/index',
        'POST api/user' => 'api/user/update',


        'GET api/pool' => 'api/pool/pools',
        'POST api/pool' => 'api/pool/create-pool',
        'GET api/pool/<pool_id:\d+>' => 'api/pool/pool',
        'DELETE api/pool/<pool_id:\d+>' => 'api/pool/delete-pool',


        'GET api/users' => 'api/users/index',
        'GET api/users/my-followers' => 'api/users/my-followers',
        'GET api/users/i-follow' => 'api/users/i-follow',


        'POST api/users/follow/<user_id:\d+>' => 'api/users/follow',
        'DELETE api/users/follow/<user_id:\d+>' => 'api/users/unfollow',


        /**
         * base url rules
         */
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
    ],
];