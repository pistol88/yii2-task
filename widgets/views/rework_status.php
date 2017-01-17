<div class="task_ajax_widget">
    <select name="ajax_rework_status" data-id="<?=$rework->id;?>" class="ajax_rework_status" autocomplete="off">
        <?php
        $statuses = yii::$app->task->statuses;;
        echo "<option selected=\"selected\" value=\"{$rework->status}\">".$statuses[$rework->status]."</option>";
        foreach($statuses as $status => $name) {
            ?>
            <option value="<?php echo $status;?>"><?php echo $name;?></option>
            <?php
        }
        ?>
    </select>
</div>