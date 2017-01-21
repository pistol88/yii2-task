<?php
use yii\helpers\Url;
use yii\helpers\Html;
use pistol88\task\widgets\MemberPrice;
use pistol88\task\widgets\MemberStatus;
use pistol88\task\widgets\MemberPayment;
use pistol88\task\widgets\MemberDeadline;
?>
<div class="task-members-widget">
    <ul class="users_list">
        <li>
            <div class="row ">
                <div class="col-md-8">
                    <h3>Сотрудники</h3>
                    <?php foreach($model->staffers as $member) { ?>
                        <div class="row memberLine">
                            <div class="col-md-10">
                                <p><a href="<?php echo Url::toRoute(["/staffer/staffer/view", 'id' => $member->id]); ?>"><strong><?php echo $member->username;?></strong></a> (<small><?php echo $member->getTaskRole(); ?></small>)</p>
                            </div>
                            <?php if(yii::$app->user->isManager()) { ?><div class="col-md-2"><a href="<?=Url::toRoute(['/task/task/remove-member', 'taskId' => $model->id, 'memberId' => $member->id]);?>" class="deleteMember btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div><?php } ?>
                            <div class="col-md-3">
                                <?=MemberStatus::widget(['task' => $model, 'member' => $member]);?>
                            </div>
                            <div class="col-md-3">
                                <?=MemberDeadline::widget(['task' => $model, 'member' => $member]);?>
                            </div>
                            <div class="col-md-3">
                                <?=MemberPrice::widget(['task' => $model, 'member' => $member]);?>
                            </div>
                            <div class="col-md-3">
                                <?=MemberPayment::widget(['task' => $model, 'member' => $member]);?>
                            </div>
                            
                        </div>
                        <hr />
                    <?php } ?>
                    
                    <?php if(yii::$app->user->isManager()) { ?>
                        <div class="newmember row">
                            <form action="<?=Url::toRoute(['/task/task/add-new-member', 'taskId' => $model->id]);?>">
                                <h4><i class="glyphicon glyphicon-plus-sign"></i> Еще сотрудник:</h4>
                                <input type="text" class="newDeveloperInput newMemberInput" name="newdeveloper" placeholder="Начните вводить имя..." autocomplete="off" />
                                
                                <div class="users-list">
                                    <ul>
                                    
                                    </ul>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <h3>Заказчики</h3>
                    <?php foreach($model->clients as $member) { ?>
                        <div class="row memberLine">
                            <div class="col-md-8">
                                <?php if(!yii::$app->user->isCustomer()) { ?><a href="<?php echo Url::toRoute(["/client/client/view", 'id' => $member->id]); ?>"><strong><?php echo $member->username;?></strong></a><?php } ?>
                                <p><small><?php echo $member->getTaskRole(); ?></small></p>
                            </div> 
                            <?php if(yii::$app->user->isManager()) { ?><div class="col-md-4"><a href="<?=Url::toRoute(['/task/task/remove-member', 'taskId' => $model->id, 'memberId' => $member->id]);?>" class="deleteMember btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div><?php } ?>
                        </div>
                    <?php } ?>
                    
                    <?php if(yii::$app->user->isManager()) { ?>
                        <div class="newmember row">
                            <form action="<?=Url::toRoute(['/task/task/add-new-member', 'taskId' => $model->id]);?>">
                                <h4><i class="glyphicon glyphicon-plus-sign"></i> Еще заказчик:</h4>
                                <input type="text" class="newClientInput newMemberInput" name="newclient" value="" placeholder="Начните вводить имя..." autocomplete="off" />
                                
                                <div class="users-list">
                                    <ul>
                                    
                                    </ul>
                                </div>
                            </form>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </li>
    </ul>



</div>
