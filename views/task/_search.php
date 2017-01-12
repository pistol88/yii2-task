<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\tools\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'date_start') ?>

    <?php // echo $form->field($model, 'date_deadline') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'accesses') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'haron_user_id') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'members_data') ?>

    <?php // echo $form->field($model, 'members') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
