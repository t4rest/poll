<?php

/* @var $this yii\web\View */
/* @var $poll \common\models\Poll */

$this->title = 'Edvice';
use frontend\assets\PollAsset;
use yii\helpers\Url;

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
                <?php if ($poll->photo_url):?>
                <img src="<?php echo $poll->photo_url; ?>" />
                <?php else: ?>
                    <div class="poll-text"><?php echo $poll->text; ?></div>
                <?php endif;?>


                <div class="caption">

                    <?php if ($poll->photo_url):?>
                        <p><?php echo $poll->text; ?></p>
                    <?php endif;?>


                    <?php if ($poll->pollUserChoice) :?>

                        <?php foreach ($poll->choices as $choice): ?>
                            <p>
                                <a href="javascript:void(0);" class="btn btn-default" role="button">
                                    <?php echo $choice->text;?>
                                </a>
                            </p>
                        <?php endforeach;?>

                    <?php else: ?>

                        <?php foreach ($poll->choices as $choice): ?>
                            <p>
                                <a href="<?php echo Url::to(['/main/poll/vote', 'poll_id' => $poll->id, 'choice_id' => $choice->id], true); ?>" class="btn btn-primary" role="button">
                                    <?php echo $choice->text;?>
                                </a>
                            </p>
                        <?php endforeach;?>

                    <?php endif;?>

                 </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
        </div>
    </div>

</div>