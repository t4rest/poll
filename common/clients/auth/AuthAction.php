<?php

namespace common\clients\auth;

use Yii;
use yii\authclient\AuthAction as MainAuth;

class AuthAction extends MainAuth
{
    public function redirect($url, $enforceRedirect = true)
    {
        $viewFile = __DIR__ . DIRECTORY_SEPARATOR;
        $viewData = [
            'token' => Yii::$app->session->get('auth_token'),
            'error' => Yii::$app->session->get('auth_error'),
            'url' => $url,
            'enforceRedirect' => $enforceRedirect,
        ];
        $response = Yii::$app->getResponse();
        $response->content = Yii::$app->getView()->renderFile($viewFile, $viewData);
        return $response;
    }
}
