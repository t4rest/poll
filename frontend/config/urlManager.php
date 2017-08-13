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

        'connect' => 'main/site/connect',

        /**
         * site controller
         */
        'site/<_a:[\w\-]+>' => 'main/site/<_a>',

        'GET poll/<poll_id:\d+>' => 'main/poll/index',
        'GET poll/<poll_id:\d+>/choice/<choice_id:\d+>' => 'main/poll/vote',


        'GET api/auth' => 'api/auth/index',


        'GET api/country' => 'api/country/index',


        'GET api/feed' => 'api/feed/feed',


        'GET api/user' => 'api/user/index',
        'POST api/user' => 'api/user/update',


        'GET api/poll' => 'api/poll/polls',
        'POST api/poll' => 'api/poll/create-poll',
        'GET api/poll/<poll_id:\d+>' => 'api/poll/poll',
        'DELETE api/poll/<poll_id:\d+>' => 'api/poll/delete-poll',


        'GET api/users' => 'api/users/index',
        'GET api/users/my-followers' => 'api/users/my-followers',
        'GET api/users/i-follow' => 'api/users/i-follow',


        'POST api/users/follow/<user_id:\d+>' => 'api/users/follow',
        'DELETE api/users/follow/<user_id:\d+>' => 'api/users/unfollow',


        'POST api/poll/<poll_id:\d+>/choice/<choice_id:\d+>' => 'api/feed/vote',

        'POST api/poll/<poll_id:\d+>/post/<client:\w+>' => 'api/poll/post',

        /**
         * base url rules
         */
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
    ],
];