<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\tools\ReworkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_deadline') ?>

    <?= $form->field($model, 'task_id') ?>

    <?php // echo $form->field($model, 'perfomer_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'payment_perfomer') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
