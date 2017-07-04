<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

/**
 * @param $data
 * @param int $exit
 */
function p($data, $exit = 1) {echo "<pre>";print_r($data);echo"</pre>";if ($exit === 1) {exit;}}