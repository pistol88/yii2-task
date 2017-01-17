<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use pistol88\task\models\Project;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_id')
        ->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Project::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите проект ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'accesses')->textarea(['rows' => 6, 'placeholder' => 'Если пусто - подставится из проекта']) ?>

    <?= $form->field($model, 'date_deadline')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyyy',
        'options' => [
            'class' => 'form-control',
        ]
    ]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(yii::$app->task->statuses, ['prompt' => 'Статус']) ?>

    <?= $form->field($model, 'payment')->dropDownList([ 'no' => 'Нет', 'yes' => 'Да', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
