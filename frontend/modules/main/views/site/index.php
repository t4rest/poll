<?php

/* @var $this yii\web\View */

$this->title = 'Edvice';

use frontend\assets\MainAsset;

MainAsset::register($this);
?>
<style>

    .intro-logo {
        height: 45px;
        width: 45px;
    }

    .intro-info-content {
        position: absolute;
        margin: auto;
        top: 35vh;
        left: 20%;
    }

    .intro-left {
        min-height: 50vh;
    }

    .intro-right {
        height: 100vh;
        background-image: linear-gradient(135deg, rgb(33, 183, 229) 0%, rgb(242, 51, 75) 100%)
    }

    .intro-image-content img {
        position: absolute;
        margin: auto;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    @media screen and (max-width: 769px) {
        .intro-info-content {
             top: 2vh;
         }

        .img-responsive{
            height: 90%;
        }176px
    }


</style>

<div class="row intro">
    <div class="col-md-6 col-sm-8 intro-left">
        <div class="intro-info-content">
            <a class="logo" href="#">
                <img class="intro-logo" src="/images/logo.png" alt="">
            </a>
            <h2>Being Productive.<br>Manage Your Life Day to Day</h2>
            <p>Let you track everything in your life with a simple way</p>
            <div class="download-btn">
                <a href="#" class="andriod">
                    <img src="/images/andriod-button.png" alt="">
                </a>
                <a href="#" class="apple">
                    <img src="/images/apple-button.png" alt="">
                </a>
            </div>

        </div>
    </div>
    <div class="col-md-6 col-sm-4 intro-right">
        <div class="intro-image-content">
            <img src="/images/intro-image.png" alt="" class="img-responsive">
        </div>
    </div>
</div>