<div class="task_ajax_widget">
    <input type="text" name="deadline" class="datepicker ajax_user_deadline" value="<?php echo yii::$app->task->dateFormat($model->date_deadline); ?>" data-task-id="<?=$model->id;?>" data-user-id="<?=$member->id;?>" placeholder="Дедлайн" />
</div>