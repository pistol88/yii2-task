<?php
use yii\helpers\Url;
use pistol88\task\assets\TaskAsset;

TaskAsset::register($this);
?>
<div class="task_head content">
    <div class="row">
    <div class="col-lg-5">
        <p class="price">
            <?php if(yii::$app->task->isManager()) { ?>
                Оценка: <input type="text" name="price" value="<?php echo $model->price; ?>" class="ajax_task_price full_task_page" data-id="<?php echo $model->id; ?>" />
                <br />
                Бюджет: <span class="dvizh_price"><?=$model->price; ?></span>
            <?php } elseif(yii::$app->task->isCustomer()) { ?>
                Общий бюджет:  <span class="ob_price"><?php echo $model->price; ?></span>
            <?php } else { ?>
                Оценка:  <span class="ta_price"><?php echo ($model->price); ?></span>
            <?php } ?>
        </p>
    </div>
    <div class="col-lg-4">
        <p class="status">Статус:
            <select name="ajax_task_status" class="ajax_task_status full_task_page" data-id="<?php echo $model->id; ?>" autocomplete="off" style="width: 90px;">
                <?php
                $statuses = yii::$app->task->statuses;;
				echo "<option selected=\"selected\" value=\"{$model->status}\">".$model->status."</option>";
                foreach($statuses as $status => $name) {
                    ?>
                    <option value="<?php echo $status;?>"><?php echo $name;?></option>
                    <?php
                }
                ?>
            </select>
        </p>
		<?php if(yii::$app->task->isManager()) { ?>
			<p class="payment">Оплата задачи:
				<select name="ajax_task_payment" class="ajax_task_payment full_task_page" data-id="<?php echo $model->id; ?>" autocomplete="off" style="width: 65px;">
					<option value="yes">Да</option>
					<option value="no"<?php if($model->payment == 'no') echo ' selected="selected"'; ?>>Нет</option>
				</select>
			</p>
		<?php } else { ?>
			<p>Оплата задачи: <?=$model->payment;?></p>
		<?php } ?>
    </div>
    <div class="col-lg-3">
        <p class="deadline">
            Дедлайн:  <br />
            <?php if(yii::$app->task->isManager()) { ?>
                <input type="text" name="deadline" class="full_task_page datepicker ajax_task_deadline" value="<?php echo $model->date_deadline; ?>" data-id="<?php echo $model->id; ?>" />
            <?php } else { ?>
                <strong><?php echo ($model->date_deadline);?></strong>
            <?php } ?>
        </p>
    </div>
    </div>
</div>
<hr />
<div class=" content " style="position: relative;">
<ul class="nav nav-tabs nav-tabs-active">
	<li class="active"><a id="tab-task" href="#task" data-toggle="tab">Задача</a></li>
	<li><a id="tab-reworks" href="#reworks" data-toggle="tab">Доработки (<?=count($model->reworks);?>)</a></li>
	<li><a id="tab-members" href="#members" data-toggle="tab">Участники</a></li>
	<li><a id="tab-actions" href="#actions" data-toggle="tab">Действия</a></li>
	<li><a id="tab-accesses" href="#accesses" data-toggle="tab">Доступы</a></li>
	<?php if(yii::$app->task->isManager()) { ?>
		<li><a id="tab-kudir" href="#kudir" data-toggle="tab">Финансы</a></li>
	<?php } ?>
	<li><a id="tab-discussion" href="#discussion" data-toggle="tab">Обсуждения</a></li>
</ul>
<br />
	<!-- Tab panes -->
<div class="tab-content content">
	<div class="tab-pane active" id="task">
		<div class="description">
			<pre><?php echo (yii::$app->prettytext->setText($model->description)->links()->getText()); ?></pre>
		</div>
	</div>
	<div class="tab-pane" id="reworks">
		<?php if(count($model->reworks) > 9) { ?>
			<a href="#" class="scroll_bottom" style="float: right;"> &darr;Перемотать вниз </a>
		<?php } ?>
		<h4><a href="#" onclick="$('#reworks .add_rework').toggle('slow'); return false;"> <i class="glyphicon glyphicon-plus"></i> Добавить правки </a> </h4>
		<form class="add_rework" action="<?=Url::toRoute('reworks/add');?>" style="display: none;">
			<input type="hidden" name="task_id" value="<?=$model->id;?>" />
			<textarea name="rework_list" placeholder="Каждая с новой строки и с цифрой в начале"></textarea>
			<p>
				<select name="rework_status">
					<?php
					$rework_statuses = yii::$app->task->statuses;
					?>
					<?php foreach($rework_statuses as $status => $name) { ?>
						<option value="<?=$status;?>" <?php if($status == 'wait') echo ' selected="selected"'; ?>><?=$name;?></option>
					<?php } ?>
				</select>
				<select name="perfomer_id" autocomplete="off">
					<option value="0">Для:</option>
					<?php foreach($model->members as $member) { ?>
						<option value="<?=$member->id;?>"><?php if(!yii::$app->task->isCustomer()) echo $member->username;?> (<?=$member->role;?>)</option>
					<?php } ?>
				</select>
                <input type="text" name="price" value="" placeholder="Оценка" />
				<input type="submit" name="add" value="Добавить" class="btn btn-submit" />
			</p>
			
			<br />
			<p>
				<input type="checkbox" id="do_notification" /> <label for="do_notification">Оповестить</label>:
				<ul class="notified_users">
					<?php foreach($model->members as $member) { ?>
						<?php if($member->id != yii::$app->user->id) { ?>
							<li><input type="checkbox" name="do_notification[<?php echo md5($member->email); ?>]" value="on" id="rework_notof_user_<?php echo $member->id; ?>" class="n_u_<?php echo $member->type;?>" /> <label for="rework_notof_user_<?php echo $member->id; ?>"><?php if(!yii::$app->task->isCustomer()) echo $member->username; ?> (<?php echo $member->role; ?>)</label> </li>
						<?php } ?>
					<?php } ?>
				</ul>
			</p>
		</form>
		
		<hr />

        <div class="reworks_control_panel">
            <?php if(!yii::$app->task->isCustomer()) { ?>
                <a href="#" class="leave_unpayment_reworks">Оставить неоплаченные</a>
            <?php } ?>
            
            Показать только:
            <?php if(false) { ?>
                <select name="reworks_filter" class="reworks_filter" autocomplete="off">
                    <option value="all">Все статусы</option>
                    <?php $rework_statuses = yii::$app->task->statuses; ?>
                    <?php foreach($rework_statuses as $status => $name) { ?>
                        <option value="<?=$status;?>"><?=$name;?></option>
                    <?php } ?>
                </select>
            <?php } ?>
            <select name="reworks_filter_members" class="reworks_filter_members" autocomplete="off">
                <option value="all">Все участники</option>
                <?php foreach($model->members as $member) { ?>
                    <option value="<?=$member->id;?>"><?php if(!yii::$app->task->isCustomer()) echo $member->username;?> (<?=$member->role; ?></option>
                <?php } ?>
            </select>
            <?php if(!yii::$app->task->isCustomer() && !yii::$app->task->isManager()) { ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        setTimeout("$('.reworks_filter_members').val(<?=yii::$app->user->id;?>); $('.reworks_filter_members').change();", 400);
                    });
                </script>
            <?php } ?>
            <span class="btn btn-default reworks_take_list">Получить список</span>
            <br /><textarea name="reworks_js_list" class="reworks_js_list"></textarea>
        </div>
		
		<?php if(empty($model->reworks)) { ?>
			<center>Правок нет.</center>
		<?php } ?>
		<ul class="reworks_list">
            <?php foreach($model->reworks as $rework) { ?>
                <li class="row rework_status_<?=$rework->status;?> rework_status_all" data-status="<?=$rework->status;?>" data-perfomer="<?=$rework->perfomer_id;?>" data-payment="<?=$rework->payment;?>"  data-payment-perfomer="<?=$rework->payment_perfomer;?>" data-price="<?=$rework->price;?>" data-ob-price="<?=$rework->price;?>" title="<?=mb_substr(str_replace("\n", '', $rework->comment), 0, 200);?>" data-perfomer-username="<?=@$model->members[$rework->perfomer_id]->username;?>" id="rework<?=$rework->id;?>">
                        <div class="col-lg-2 row">
                            <div class="col-lg-6">
                                <input type="checkbox" class="rework_check" data-number="<?=$rework->number;?>" value="<?=$rework->id;?>" autocomplete="off" />
                            </div>
                            <div class="col-lg-6">
                                <strong class="number" title="<?=$rework->date_start;?>">#<span><?=$rework->number;?></span></strong>.
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="rework_text"><?php echo nl2br(yii::$app->prettytext->setText($rework->text)->links()->getText()); ?></div>
                            <div style="display: none;" class="clear_rework_text"><?=$rework->text;?></div>
                                <div style="clear: both;"></div>
                                <div class="rework_comments">

                                </div>

                            
                            <?php if(yii::$app->task->isManager() && $rework->price > 0) { ?>
                                <p class="price">Бюджет: <span class="dvizh_price"><?php echo $rework->price; ?></span></p>
                            <?php } ?>
                        </div>
                        <div class="col-lg-2 right_col">
                            <p><select name="ajax_rework_status" data-id="<?=$rework->id;?>" class="ajax_rework_status" autocomplete="off">
                                <?php
                                $rework_statuses = yii::$app->task->statuses;
                                ?>
                                <?php foreach($rework_statuses as $status => $name) { ?>
                                    <option value="<?=$status;?>" <?php if($rework->status == $status) echo ' selected="selected"'; ?>><?=$name;?></option>
                                <?php } ?>
                            </select>
                            <?php if($rework->price > 0) { ?>
                                <span class="little">
                                    <?php if(yii::$app->task->isCustomer()) { ?><?php echo $rework->price; ?><?php } elseif(yii::$app->task->isManager()) { ?><?php echo $rework->price; ?><?php } else { ?><?php echo ($rework->price); ?><?php } ?>
                                </span>
                            <?php } ?>
                            </p>
                            <?php if(isset($model->members)) { ?>
                                <p class="developer">
                                    <select name="ajax_rework_perfomer" data-id="<?=$rework->id;?>" class="ajax_rework_perfomer" autocomplete="off">
                                        <option value="0">-</option>
                                        <?php foreach($model->members as $member) { ?>
                                            <option <?php if($member->id == $rework->perfomer_id) echo 'selected="selected"'; ?> value="<?=$member->id;?>"><?php if(!yii::$app->task->isCustomer()) { ?><?=$member->username;?><?php } ?> (<?=$member->role;?>)</option>
                                        <?php } ?>
                                    </select>
                                </p>
                            <?php } ?>
                            <p class="price">
                                <?php if(!isset($from_arrear) && (yii::$app->task->isManager() | yii::$app->task->isDeveloper())) { ?>
                                    Оценка: <input type="text" name="price" value="<?php echo $rework->price; ?>" class="ajax_rework_price" data-id="<?php echo $rework->id; ?>" />
                                <?php } else { ?>
                                    <?php if(yii::$app->task->isCustomer()) { ?>
                                        Общий бюджет:  <span class="ta_price"><?=$rework->price;?></span>
                                    <?php } else { ?>
                                        Оценка:  <span class="ta_price"><?=$rework->price;?></span>
                                    <?php } ?>
                                <?php } ?>
                            </p>
                            
                            <?php if(yii::$app->task->isManager() | $rework->perfomer_id == yii::$app->user->id) { ?>
                                <p class="payment"<?php if($rework->price <= 0) { ?> style="display: none;"<?php } ?>>
                                    Оплачено:<br />
                                    <input type="radio" name="ajax_rework_payment<?php echo $rework->id; ?>" class="ajax_rework_payment" id="ajax_rework_payment_no<?php echo $rework->id; ?>" value="no" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment == 'no') echo ' checked'; ?> />
                                    <label>Нет</label>
                                    
                                    <input type="radio" name="ajax_rework_payment<?php echo $rework->id; ?>" class="ajax_rework_payment" id="ajax_rework_payment_yes<?php echo $rework->id; ?>" value="yes" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment == 'yes') echo ' checked'; ?> />
                                    <label>Да</label>
                                    
                                    <br />
                                    
                                    Выплата сотруднику:<br />
                                    <input type="radio" name="ajax_rework_payment_perfomer<?php echo $rework->id; ?>" class="ajax_rework_payment_perfomer" id="ajax_rework_payment_no_perfomer<?php echo $rework->id; ?>" value="no" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment_perfomer == 'no') echo ' checked'; ?> />
                                    <label for="ajax_rework_payment_no_perfomer<?php echo $rework->id; ?>">Нет</label>
                                    
                                    <input type="radio" name="ajax_rework_payment_perfomer<?php echo $rework->id; ?>" class="ajax_rework_payment_perfomer" id="ajax_rework_payment_yes_perfomer<?php echo $rework->id; ?>" value="yes" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment_perfomer == 'yes') echo ' checked'; ?> />
                                    <label for="ajax_rework_payment_yes_perfomer<?php echo $rework->id; ?>">Да</label>
                                </p>
                            <?php } ?>
                        </div>
                    </li>

            <?php } ?>
			<?php if(!empty($reworks)) { ?>
				<li class="row" style="padding-left: 40px; list-style: none;">
					<label for="all_reworks_checked">Все</label> <input id="all_reworks_checked" type="checkbox" class="rework_check_all" autocomplete="off" />
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="tab-pane" id="members">
			<?php if(isset($model->members) && !empty($model->members)) { ?>

					<ul class="users_list">
					<?php foreach($model->members as $d) { ?>
						<li class="row">
                            <div class="col-lg-2">
                                <?php if(isset($d->avatar) && !empty($d->avatar)) { ?>
                                    <div class="avatar"><a href="<?php echo Url::toRoute("profile/view/$d->id"); ?>"><img src="<?php echo base_url("upload/avatars/$d->avatar"); ?>" /></a></div>
                                <?php } ?>
								<?php if($d->type == 'customer') { ?>
									Заказчик:
								<?php } ?>
                                <?php if(!yii::$app->task->isCustomer()) { ?><a href="<?php echo Url::toRoute("profile/view/$d->id"); ?>"><strong><?php echo $d->username;?></strong></a><?php } ?>
								<p><small><?php echo $d->role; ?></small></p>
							</div> 
                            <?php if($d->type != 'customer' && !in_array($d->role, yii::$app->task->notDevelopersRoles)) { ?>
                                <div class="status col-lg-10">
                                    <div class="row">
                                        <?php if(yii::$app->task->isManager()) { ?>
                                            <div class="col-lg-4">
                                                Оплачено:<br />
                                                <input name="ajax_user_price" placeholder="" value="<?php echo $d->price;?>" class="ajax_user_price" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $d->id; ?>"><br />
                                                
                                                Оплачен:<br />
                                                <input type="radio" name="ajax_user_payment<?php echo $d->id; ?>" class="ajax_user_payment" id="ajax_user_payment_no<?php echo $d->id; ?>" value="no" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $d->id; ?>" <?php if($d->payment == 'no') echo ' checked'; ?> />
                                                <label for="ajax_user_payment_no<?php echo $d->id; ?>">Нет</label>
                                                <input type="radio" name="ajax_user_payment<?php echo $d->id; ?>" class="ajax_user_payment" id="ajax_user_payment_yes<?php echo $d->id; ?>" value="yes" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $d->id; ?>" <?php if($d->payment == 'yes') echo ' checked'; ?> />
                                                <label for="ajax_user_payment_yes<?php echo $d->id; ?>">Да</label>
                                                
                                            </div>
                                            <div class="col-lg-4">
                                                Дедлайн:<br />
                                                <input name="ajax_user_deadline" value="<?php echo get_deadline_date($d->deadline);?>" class="datepicker ajax_user_deadline" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $d->id; ?>">
                                            </div>
                                        <?php } else { ?>
											<div class="col-lg-4">
												<?php if($d->id == yii::$app->user->id) { ?>
													Оплплата:<br /> <?php echo $d->price;?><br />
													Оплачено:<br /> <?php echo $d->payment; ?>
												<?php } ?>
											</div>
                                            <div class="col-lg-4">Дедлайн:<br /> <?php echo $date; ?></div>
                                        <?php } ?>
                                        
                                        <?php if(yii::$app->task->isManager() | $d->id == yii::$app->user->id) { ?>
                                            <div class="col-lg-4">
                                                <p class="status">
                                                    Статус:
                                                    <select autocomplete="off" name="ajax_user_status" class="full_task_page ajax_user_status" data-task-id="<?php echo $model->id; ?>" data-user-id="<?php echo $d->id; ?>">
                                                        <?php
                                                        
														$statuses = yii::$app->task->statuses;;
														echo "<option selected=\"selected\" value=\"{$d->status}\">".$d->status."</option>";
                                                        foreach($statuses as $status => $name) {
                                                            ?>
                                                            <option value="<?php echo $status;?>"><?php echo $name;?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </p>
                                            </div>
                                        <?php } else { ?>
                                            <p>Статус: <?=$d->status;?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
						</li>
					<?php } ?>
					</ul>
			<?php } ?>
	</div>
	<div class="tab-pane actions_list" id="actions">
		<?php if(!empty($model->actions)) { ?>
			<ul>
				<?php
				foreach($model->actions as $action) {
					echo "<li><b>{$action->username}</b> [<small>".date('d.m.Y H:i:s', $action->time)."</small>]: {$action->text}</li>";
				}
				?>
			</ul>
		<? } ?>
	</div>
	<div class="tab-pane" id="accesses">
		<pre><?php echo yii::$app->prettytext->setText($model->accesses)->links()->getText(); ?></pre>
	</div>
	<?php if(yii::$app->task->isManager()) { ?>
		<div class="tab-pane" id="kudir">

		</div>
	<?php } ?>
	<div class="tab-pane" id="discussion">
		
	</div>
</div>
</div>