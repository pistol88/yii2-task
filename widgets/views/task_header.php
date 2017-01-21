<?php
use pistol88\task\widgets\TaskPrice;
use pistol88\task\widgets\TaskStatus;
use pistol88\task\widgets\TaskPayment;
use pistol88\task\widgets\TaskDeadline;
?>
    <div class="row tashHeader tashHeader<?=$model->id;?>">
        <div class="col-lg-5">
            <?php if(yii::$app->user->isManager()) { ?>
                <?=TaskPrice::widget(['task' => $model]);?>
                Бюджет: <span class="dvizh_price"><?=$model->endprice; ?></span>
            <?php } elseif(yii::$app->user->isCustomer()) { ?>
                Общий бюджет:  <span class="ob_price"><?php echo $model->endprice; ?></span>
            <?php } else { ?>
                Оценка:  <span class="ta_price"><?php echo $model->price; ?></span>
            <?php } ?>
            <?php if(yii::$app->user->isManager()) { ?>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#payment-<?=$model->id;?>">Оплата</button>
                
                <div id="payment-<?=$model->id;?>" class="modal fade" role="dialog" data-role="modal-repayment">
                    <div class="modal-dialog" style="width: 430px;">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Оплата заказа № <?=$model->id;?></h4>
                            </div>
                            <div class="modal-body">
                                <?=\halumein\cashbox\widgets\RepaymentForm::widget(['useAjax' => true, 'order' => $model]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-lg-4">
            <?=TaskStatus::widget(['task' => $model]);?>

            <?php if(yii::$app->user->isManager()) { ?>
                <?=TaskPayment::widget(['task' => $model]);?>
            <?php } else { ?>
                <p>Оплата задачи: <?=$model->payment;?></p>
            <?php } ?>
        </div>
        <div class="col-lg-3">
            <p class="deadline">
                <?php if(yii::$app->user->isManager()) { ?>
                    <?=TaskDeadline::widget(['task' => $model]);?>
                <?php } else { ?>
                    <strong><?php echo yii::$app->task->dateFormat($model->date_deadline);?></strong>
                <?php } ?>
            </p>
        </div>
    </div>