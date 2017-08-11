<?php

/* @var $this yii\web\View */
/* @var $poll \common\models\Poll */

$this->title = 'Edvice';
use frontend\assets\PollAsset;

PollAsset::register($this);
?>
<div class="poll-index">

    <div class="row">
        <div class="col-sm-6 col-md-4">
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail poll">
                <div class="poll-header">

                    <a href="#" class="pull-left">
                        <img src="<?php echo $poll->user->photo_url?>" class="avatar img-circle pull-left">
                        <span class="header-username pull-right"><?php echo $poll->user->username; ?></span>
                    </a>
                </div>
                <img src="<?php echo $poll->photo_url; ?>" />

                <div class="caption">

                    <p><?php echo $poll->text; ?></p>

                    <?php foreach ($poll->choices as $choice): ?>
                    <p>
                        <a href="javascript:void(0);" class="btn btn-primary" role="button">
                            <?php echo $choice->text;?>
                        </a>
                    </p>
                    <?php endforeach;?>
                 </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
        </div>
    </div>

</div>