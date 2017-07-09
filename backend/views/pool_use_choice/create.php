<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PoolUserChoice */

$this->title = 'Create Pool User Choice';
$this->params['breadcrumbs'][] = ['label' => 'Pool User Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pool-user-choice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
