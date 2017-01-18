<?php
$relation = $member->getTaskRelation($model);
?>
<div class="task_ajax_widget">
    <?php if(yii::$app->user->isManager()) { ?>
        <input type="text" name="price" value="<?=$member->getTaskPrice($model); ?>" class="ajax_user_price" data-task-id="<?=$model->id; ?>" data-user-id="<?=$member->id; ?>" placeholder="Оценка" style="width: 60px;" />
    <?php } else { ?>
        <p>Оценка: <?=$member->getTaskPrice($model); ?></p>
    <?php } ?>
    <?php if(yii::$app->user->isManager()) { ?>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#payment-<?=$relation->id;?>">Оплата</button>
        
        <div id="payment-<?=$relation->id;?>" class="modal fade" role="dialog" data-role="modal-repayment">
            <div class="modal-dialog" style="width: 430px;">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Оплата № <?=$relation->id;?></h4>
                    </div>
                    <div class="modal-body">
                        <?=\halumein\cashbox\widgets\RepaymentForm::widget(['useAjax' => true, 'order' => $relation]); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>