<?php

/* @var $this yii\web\View */
/* @var $poll \common\models\Poll */

$this->title = 'Edvice';
use yii\helpers\Url;

?>
<div class="page post">
    <div class="container-fluid">
        <div class="row align-items-center post-page-header">
            <div class="col-12 col-md-6">
                <a class="logo" src="#"><span class="logo-img"></span><span class="logo-text">Edvice</span></a>
            </div>
            <div class="col-12 col-md-6">
                <a href="#" class="create-poll-btn">Create your poll</a>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-12">
                <div class="post-block">
                    <div class="post-header">
                        <a href="#" class="post-creator">
                            <span class="post-creator-avatar">
                                <img src="<?php echo $poll->user->photo_url ?>" alt="" class="post-creator-avatar-img">
                            </span>
                            <span class="post-creator-data">
                                <span class="post-creator-name"><?php echo $poll->user->username; ?></span>
                                <span class="post-time-create">1 minute left</span>
                            </span>
                        </a>
                    </div>

                    <div class="post-body">

                        <?php if ($poll->photo_url): ?>
                            <div class="post-image">
                                <img src="/img/img.jpg" alt="">
                            </div>
                        <?php endif; ?>

                        <div class="post-question"><?php echo $poll->text; ?> </div>
                        <?php if ($poll->pollUserChoice) : ?>
                            <div class="post-results">
                                <?php foreach ($poll->choices as $choice): ?>
                                    <div class="post-result <?php echo ($poll->pollUserChoice->choice_id == $choice->id) ? 'is-chosen' : ''; ?>">
                                        <div class="post-result-line" style="width: 59%"></div>
                                        <div class="post-result-text"><?php echo $choice->text; ?> <span
                                                    class="post-result-text-icon"></span>
                                        </div>
                                        <div class="post-result-percent">59%</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php else: ?>

                            <div class="post-variants">
                                <?php foreach ($poll->choices as $choice): ?>
                                    <p>
                                        <button href="<?php echo Url::to(['/main/poll/vote', 'poll_id' => $poll->id, 'choice_id' => $choice->id], true); ?>"
                                                class="post-variant" role="button">
                                            <?php echo $choice->text; ?>
                                        </button>
                                    </p>
                                <?php endforeach; ?>
                            </div>

                        <?php endif; ?>


                    </div>
                </div>
                <div class="success-message">
                    <span>Thanks for you vote! </span><br>Try to create your poll.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="overlay">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <div class="overlay-wrapper">
                    <div class="img-overlay">
                        <img src="/img/img-big.jpg" alt="">
                    </div>
                    <button class="close-overlay"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
    //    $('.post-variant').on('click', function (){
    //        $(this).parent().slideUp();
    //        $('.post-results').slideDown();
    //        $('.success-message').fadeIn();
    //    });

    $('.post-image').on('click', function () {
        $('.overlay').fadeIn();
    });

    $('.close-overlay').on('click', function () {
        $('.overlay').fadeOut();
    });
</script>