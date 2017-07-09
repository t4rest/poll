<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PoolUserChoice */

$this->title = $model->pool_id;
$this->params['breadcrumbs'][] = ['label' => 'Pool User Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pool-user-choice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pool_id' => $model->pool_id, 'user_id' => $model->user_id, 'choice_id' => $model->choice_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pool_id' => $model->pool_id, 'user_id' => $model->user_id, 'choice_id' => $model->choice_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pool_id',
            'user_id',
            'choice_id',
            'date',
        ],
    ]) ?>

</div>
