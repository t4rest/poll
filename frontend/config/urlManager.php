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
        ['pattern' => 'api/user/photo', 'verb' => 'POST', 'route' => 'api/user/photo'],


        ['pattern' => 'api/pool', 'verb' => 'GET',  'route' => 'api/user/index'],
        ['pattern' => 'api/pool', 'verb' => 'POST', 'route' => 'api/user/update'],
        ['pattern' => 'api/pool', 'verb' => 'PUT',  'route' => 'api/user/photo'],


        /**
         * base url rules
         */
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
    ],
];