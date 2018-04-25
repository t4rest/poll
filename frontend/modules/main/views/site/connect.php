<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'poll';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-connect">

    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => true,
    ]) ?>

</div>
