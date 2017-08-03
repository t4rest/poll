<?php

namespace backend\controllers;

use common\exceptions;
use yii;

abstract class AuthController extends BaseController
{
    /**
     * @param yii\base\Action $action
     * @return bool
     * @throws exceptions\AuthorizationException
     * @throws yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $token = Yii::$app->request->getQueryParam('oauth_token');

        if (!Yii::$app->user->loginByAccessToken($token)) {
            throw exceptions\AuthorizationException::invalidToken();
        }

        return parent::beforeAction($action);
    }
}
