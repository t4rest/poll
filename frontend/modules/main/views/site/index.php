<?php

/* @var $this yii\web\View */

$this->title = 'Edvice';
?>
<div class="site-index">

    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => true,
    ]) ?>

</div>
