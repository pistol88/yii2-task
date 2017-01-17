<div class="task_ajax_widget">
    <select name="ajax_task_status" class="ajax_task_status full_task_page" data-id="<?php echo $model->id; ?>" autocomplete="off" style="width: 90px;">
        <?php
        $statuses = yii::$app->task->statuses;;
        echo "<option selected=\"selected\" value=\"{$model->status}\">".$statuses[$model->status]."</option>";
        foreach($statuses as $status => $name) {
            ?>
            <option value="<?php echo $status;?>"><?php echo $name;?></option>
            <?php
        }
        ?>
    </select>
</div>