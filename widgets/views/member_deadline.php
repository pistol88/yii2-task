<?php
use yii\jui\DatePicker;
?>
<div class="task_ajax_widget">
    <?php if($member->id == yii::$app->user->member->id) { ?>
        <?=DatePicker::widget([
            'name'  => 'deadline',
            'value'  => yii::$app->task->dateFormat($model->date_deadline),
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
            'options' => [
                'class' => 'datepicker ajax_user_deadline',
                'data-user-id' => $member->id,
                'data-task-id' => $model->id,
                'placeholder' => 'Дедлайн',
            ],
        ]);?>
    <?php } else { ?>
        <p><?=yii::$app->task->dateFormat($model->date_deadline);?></p>
    <?php } ?>

</div>