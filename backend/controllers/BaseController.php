<?php

namespace backend\controllers;

use common\exceptions;
use yii\web\Controller;
use yii;

abstract class BaseController extends Controller
{
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * @param array|bool $data
     * @return array
     */
    public function responseSuccess($data): array
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
