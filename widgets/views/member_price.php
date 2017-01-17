<div class="task_ajax_widget">
    <?php if(yii::$app->user->isManager()) { ?>
        <input type="text" name="price" value="<?=$member->getTaskPrice($model); ?>" class="ajax_user_price" data-task-id="<?=$model->id; ?>" data-user-id="<?=$member->id; ?>" placeholder="Оценка" />
    <?php } else { ?>
        <p>Оценка: <?=$member->getTaskPrice($model); ?></p>
    <?php } ?>
</div>