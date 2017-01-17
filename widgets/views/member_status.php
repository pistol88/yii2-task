<div class="task_ajax_widget">
    <?php if(yii::$app->user->isManager()) { ?>
        <select autocomplete="off" name="ajax_user_status" class="full_task_page ajax_user_status" data-task-id="<?=$model->id;?>" data-user-id="<?=$member->id;?>">
            <?php
            
            $statuses = yii::$app->task->statuses;;
            echo "<option selected=\"selected\" value=\"".$member->getTaskStatus($model)."\">".$statuses[$member->getTaskStatus($model)]."</option>";
            foreach($statuses as $status => $name) {
                ?>
                <option value="<?php echo $status;?>"><?php echo $name;?></option>
                <?php
            }
            ?>
        </select>
    <?php } else { ?>
        <p>Статус: <?=$member->getTaskStatus($model);?></p>
    <?php } ?>
</div>