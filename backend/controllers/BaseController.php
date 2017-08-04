<?php

namespace backend\controllers;

use yii\web\Controller;
use common\pagination;
use yii\web\Response;

abstract class BaseController extends Controller
{
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /**
     * @param $data
     * @param pagination\OffsetBased|null $pagination
     * @return array
     */
    public function responseSuccess($data, pagination\OffsetBased $pagination = null): array
    {
        $response = [
            'status' => 'success',
            'data' => $data
        ];

        if (!empty($pagination)) {
            $response['next'] = $pagination->issetNext();
        }

        return $response;
    }
}
