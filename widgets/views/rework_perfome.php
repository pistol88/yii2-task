<div class="task_ajax_widget">
    <select name="ajax_rework_perfomer" data-id="<?=$rework->id;?>" class="ajax_rework_perfomer" autocomplete="off">
        <option value="0">-</option>
        <?php foreach($rework->members as $member) { ?>
            <option <?php if($member->id == $rework->perfomer_id) echo 'selected="selected"'; ?> value="<?=$member->id;?>"><?php if(!yii::$app->user->isCustomer()) { ?><?=$member->username;?><?php } ?> (<?=$member->getTaskRole();?>)</option>
        <?php } ?>
    </select>
</div>