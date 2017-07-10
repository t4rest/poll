<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PoolChoice */

$this->title = 'Create Pool Choice';
$this->params['breadcrumbs'][] = ['label' => 'Pool Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pool-choice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
