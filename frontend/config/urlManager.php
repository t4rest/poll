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


        ['pattern' => 'api/user', 'verb' => 'GET', 'route' => 'api/user/index'],
        ['pattern' => 'api/user', 'verb' => 'POST', 'route' => 'api/user/update'],


        'GET api/pool' => 'api/pool/pools',
        'POST api/pool' => 'api/pool/create-pool',
        'GET api/pool/<pool_id:\d+>' => 'api/pool/pool',
        'DELETE api/pool/<pool_id:\d+>' => 'api/pool/delete-pool',


        /**
         * base url rules
         */
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
    ],
];