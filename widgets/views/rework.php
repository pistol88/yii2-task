<?php
use pistol88\task\widgets\ReworkPrice;
use pistol88\task\widgets\ReworkStatus;
use pistol88\task\widgets\ReworkPayment;
use pistol88\task\widgets\ReworkDeadline;
use pistol88\task\widgets\ReworkPerfome;
?>
        <li class="row rework_status_<?=$rework->status;?> rework_status_all rework_<?=$rework->id;?>" data-status="<?=$rework->status;?>" data-perfomer="<?=$rework->perfomer_id;?>" data-payment="<?=$rework->payment;?>"  data-payment-perfomer="<?=$rework->payment_perfomer;?>" data-price="<?=$rework->price;?>" data-ob-price="<?=$rework->price;?>" title="<?=mb_substr(str_replace("\n", '', $rework->comment), 0, 200);?>" data-perfomer-username="<?php if($perfomer = $rework->perfomer) echo $perfomer->name;?>" id="rework<?=$rework->id;?>">
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
                            <?php /* echo \yii2mod\comments\widgets\Comment::widget([
                                'model' => $rework,
                                'formId' => 'comment-form-rework'.$rework->id,
                                'pjaxContainerId' => 'unique-pjax-container-id-rework'.$rework->id
                            ]); */ ?>
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