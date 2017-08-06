<?php
namespace frontend\modules\main\controllers;

use frontend\modules\main\components\MainController;

class PollController extends MainController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
