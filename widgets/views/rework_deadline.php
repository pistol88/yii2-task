<?php
use yii\jui\DatePicker;
?>
<div class="task_ajax_widget">
    <?=DatePicker::widget([
        'name'  => 'deadline',
        'value'  => yii::$app->task->dateFormat($rework->date_deadline),
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyyy',
        'options' => [
            'class' => 'datepicker ajax_rework_deadline',
            'data-id' => $rework->id,
            'placeholder' => 'Дедлайн',
        ],
    ]);?>
</div>