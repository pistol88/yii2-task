<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\jui\DatePicker;
use pistol88\task\widgets\ReworkPrice;
use pistol88\task\widgets\ReworkStatus;
use pistol88\task\widgets\ReworkPayment;
use pistol88\task\widgets\ReworkDeadline;
use pistol88\task\widgets\ReworkPerfome;
?>

<?php if(count($model->reworks) > 9) { ?>
    <a href="#" class="scroll_bottom" style="float: right;"> &darr;Перемотать вниз </a>
<?php } ?>
<h4><a href="#" onclick="$('#reworks .add_rework').toggle('slow'); return false;"> <i class="glyphicon glyphicon-plus"></i> Добавить правки </a> </h4>
<form class="add_rework" action="<?=Url::toRoute('/task/rework/add');?>" style="display: none;">
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
                <option value="<?=$member->id;?>"><?php if(!yii::$app->user->isCustomer()) echo $member->username;?> (<?=$member->getTaskRole();?>)</option>
            <?php } ?>
        </select>
        <?=DatePicker::widget([
            'name'  => 'deadline',
            'value'  => '',
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
            'options' => [
                'class' => 'full_task_page datepicker ajax_task_deadline',
                'placeholder' => 'Дедлайн',
                'style' => 'width: 82px',
            ],
        ]);?>
        <input type="text" name="price" value="" placeholder="Оценка" style="width: 70px;" />
        <input type="submit" name="add" value="Добавить" class="btn btn-submit" />
    </p>
</form>

<hr />

<div class="reworks_control_panel">
    <?php if(!yii::$app->user->isCustomer()) { ?>
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
            <option value="<?=$member->id;?>"><?php if(!yii::$app->user->isCustomer()) echo $member->username;?> (<?=$member->getTaskRole(); ?></option>
        <?php } ?>
    </select>
    <?php if(!yii::$app->user->isCustomer() && !yii::$app->user->isManager()) { ?>
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
        <li class="row rework_status_<?=$rework->status;?> rework_status_all" data-status="<?=$rework->status;?>" data-perfomer="<?=$rework->perfomer_id;?>" data-payment="<?=$rework->payment;?>"  data-payment-perfomer="<?=$rework->payment_perfomer;?>" data-price="<?=$rework->price;?>" data-ob-price="<?=$rework->price;?>" title="<?=mb_substr(str_replace("\n", '', $rework->comment), 0, 200);?>" data-perfomer-username="<?php if($perfomer = $rework->perfomer) echo $perfomer->name;?>" id="rework<?=$rework->id;?>">
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
                            <?php echo \yii2mod\comments\widgets\Comment::widget([
                                'model' => $rework,
                                'formId' => 'comment-form-rework'.$rework->id,
                                'pjaxContainerId' => 'unique-pjax-container-id-rework'.$rework->id
                            ]); ?>
                        </div>
                </div>
                <div class="col-lg-2 right_col">
                    <?=ReworkStatus::widget(['rework' => $rework]);?>
                    <?php if($rework->price > 0) { ?>
                        <p>
                            <span class="little">
                                <?php if(yii::$app->user->isCustomer()) { ?><?php echo $rework->price; ?><?php } elseif(yii::$app->user->isManager()) { ?><?php echo $rework->price; ?><?php } else { ?><?php echo ($rework->price); ?><?php } ?>
                            </span>
                        </p>
                    <?php } ?>
                    
                    <?=ReworkPrice::widget(['rework' => $rework]);?>

                    <?=ReworkDeadline::widget(['rework' => $rework]);?>
                    
                    
                    <?=ReworkPerfome::widget(['rework' => $rework]);?>
                    
                    <?php if(yii::$app->user->isManager()) { ?>
                        <?=ReworkPayment::widget(['rework' => $rework]);?>
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

<div class="row reworks_mass">
    Отмеченные доработки:
    <div class="reworks_mass_price">
        <p>Заказчик: <span class="z">0</span>, Исполнитель: <span class="i">0</span></p>
    </div>

    <ul class="reworks_mass_userlist">

    </ul>
    <p class="reworks_mass_checked_ids"></p>
    <ul>
        <?php if(yii::$app->user->isManager()) { ?>
            <li><button class="btn btn-default rework_mass_payment">Оплачено заказчиком</button></li>
            <li><button class="btn btn-default rework_mass_payment_member">Оплачено исполнителю</button></li>
            <li><hr /></li>
        <?php } ?>
        <li><button class="btn btn-default rework_mass_status_active" style="border: 1px solid green;"><i class="glyphicon glyphicon-play"></i> В работе</button></li>
        <li><button class="btn btn-success rework_mass_status_done"><i class="glyphicon glyphicon-stop"></i> Выполнено</button></li>
        <?php if(yii::$app->user->isManager()) { ?>
            <li><button class="btn btn-default rework_mass_status_close"><i class="glyphicon glyphicon-ok-sign"></i> Сдано</button></li>
        <?php } ?>
    </ul>
</div>

<div id="payment-to-reworks" class="modal fade" role="dialog" data-role="modal-repayment">
    <div class="modal-dialog" style="width: 430px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Оплата в задаче № <?=$model->id;?></h4>
            </div>
            <div class="modal-body">
                <?=\halumein\cashbox\widgets\RepaymentForm::widget(['useAjax' => true, 'order' => $model]); ?>
            </div>
        </div>
    </div>
</div>