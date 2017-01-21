<div class="task_ajax_widget">
    <?php if(yii::$app->user->isManager()) { ?>
        <p>
            <input type="radio" name="ajax_user_payment<?php echo $member->id; ?>" class="ajax_user_payment" id="ajax_user_payment_no<?php echo $member->id; ?>" value="no" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $member->id; ?>" <?php if($member->getTaskPayment($model) == 'no') echo ' checked'; ?> />
            <label for="ajax_user_payment_no<?php echo $member->id; ?>">Не оплачено</label><br />
            <input type="radio" name="ajax_user_payment<?php echo $member->id; ?>" class="ajax_user_payment" id="ajax_user_payment_yes<?php echo $member->id; ?>" value="yes" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $member->id; ?>" <?php if($member->getTaskPayment($model) == 'yes') echo ' checked'; ?> />
            <label for="ajax_user_payment_yes<?php echo $member->id; ?>">Оплачено</label>
        </p>

    <?php } else { ?>
        <p>
            <?php if($member->id == yii::$app->user->id) { ?>
                Оплачено:<br /> <?php echo $member->getTaskPayment($model); ?>
            <?php } ?>
        </p>
    <?php } ?>
</div>