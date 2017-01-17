<div class="task_ajax_widget">
    <select name="ajax_task_payment" class="ajax_task_payment full_task_page" data-id="<?php echo $model->id; ?>" autocomplete="off" style="width: 65px;">
        <option value="yes">Да</option>
        <option value="no"<?php if($model->payment == 'no') echo ' selected="selected"'; ?>>Нет</option>
    </select>
</div>