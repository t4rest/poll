<?php
namespace common\exceptions;

use Yii;
use yii\web\ErrorHandler as Error;

class ErrorHandler extends Error {

    protected function renderException($exception)
    {
        Yii::$app->response->data = $this->convertExceptionToArray($exception);
        Yii::$app->response->send();
    }


    protected function convertExceptionToArray($exception)
    {
        if ($exception instanceof ApisException) {
            return [
                "status" => "fail",
                'data' => $exception->getMessage(),
            ];
        } else {
            return [
                "status" => "error",
                'message' => $exception->getMessage()
            ];
        }
    }
}