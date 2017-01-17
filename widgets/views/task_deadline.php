<?php
use yii\jui\DatePicker;
?>
<div class="task_ajax_widget">
    <?=DatePicker::widget([
        'name'  => 'deadline',
        'value'  => yii::$app->task->dateFormat($model->date_deadline),
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyy',
        'class' => 'full_task_page datepicker ajax_task_deadline',
        'options' => [
            'data-id' => $model->id,
        ],
    ]);?>
</div>