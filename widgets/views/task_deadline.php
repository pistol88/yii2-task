<?php
use yii\jui\DatePicker;
?>
<div class="task_ajax_widget">
    <?=DatePicker::widget([
        'name'  => 'deadline',
        'value'  => yii::$app->task->dateFormat($model->date_deadline),
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyyy',
        'options' => [
            'class' => 'full_task_page datepicker ajax_task_deadline',
            'data-id' => $model->id,
            'placeholder' => 'Дедлайн',
        ],
    ]);?>
</div>