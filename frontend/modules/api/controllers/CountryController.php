<?php

namespace frontend\modules\api\controllers;

use backend\modules\country\api\Country;
use frontend\modules\api\components\MainController;

class CountryController extends MainController
{
    /**
     * @var Country
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Country();
        }
        return true;
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return $this->responseSuccess(
            $this->api->country()
        );
    }

}
