<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pool */
/* @var $type common\models\PoolType */

$this->title = 'Update Pool: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pool-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
