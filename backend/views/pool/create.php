<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pool */
/* @var $type common\models\PoolType */

$this->title = 'Create Pool';
$this->params['breadcrumbs'][] = ['label' => 'Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
