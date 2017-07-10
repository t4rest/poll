<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PoolUserChoice */

$this->title = 'Update Pool User Choice: ' . $model->pool_id;
$this->params['breadcrumbs'][] = ['label' => 'Pool User Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pool_id, 'url' => ['view', 'pool_id' => $model->pool_id, 'user_id' => $model->user_id, 'choice_id' => $model->choice_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pool-user-choice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
