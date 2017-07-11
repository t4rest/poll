<?php

namespace backend\controllers;

use common\exceptions;
use yii\web\Controller;
use yii;

abstract class AuthController extends Controller
{
    public function init()
    {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

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

    /**
     * @param array $data
     * @return array
     */
    public function responseSuccess( array $data): array
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
