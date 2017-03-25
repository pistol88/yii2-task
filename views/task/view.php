<?php
use yii\helpers\Url;
use pistol88\task\assets\TaskAsset;
use pistol88\task\widgets\Members;
use pistol88\task\widgets\Reworks;
use pistol88\task\widgets\TaskHeader;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
if($project = $model->project) {
    $this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => Url::toRoute(['/task/task/index', 'TaskSearch' => ['project_id' => $project->id]])];
}
$this->params['breadcrumbs'][] = $this->title;

TaskAsset::register($this);
?>
<div class="task_head content">
    <h1>
        <?=$model->name;?>
        <?php if(yii::$app->user->isManager()) { ?>
            <a href="<?=Url::toRoute(['/task/task/update', 'id' => $model->id]);?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
        <?php } ?>
    </h1>
    <?=TaskHeader::widget(['task' => $model]);?>
</div>
<hr />
<div class=" content " style="position: relative;">
    <ul class="nav nav-tabs nav-tabs-active">
        <li class="active"><a id="tab-task" href="#task" data-toggle="tab">Задача</a></li>
        <li><a id="tab-reworks" href="#checkpoints" data-toggle="tab">Вехи</a></li>
        <li><a id="tab-reworks" href="#reworks" data-toggle="tab">Доработки (<?=count($model->reworks);?>)</a></li>
        <?php if(!yii::$app->user->isCustomer()) { ?>
            <li><a id="tab-members" href="#members" data-toggle="tab">Участники</a></li>
        <?php } ?>
        <li><a id="tab-actions" href="#actions" data-toggle="tab">Действия</a></li>
        <li><a id="tab-accesses" href="#accesses" data-toggle="tab">Доступы</a></li>
        <li><a id="tab-discussion" href="#discussion" data-toggle="tab">Обсуждения</a></li>
    </ul>
    <br />
    <!-- Tab panes -->
    <div class="tab-content content">
        <div class="tab-pane active" id="task">
            <div class="description">
                <?=$model->description;?>
            </div>
        </div>
        <div class="tab-pane" id="checkpoints">
            <p>Раздел в разработке...</p>
        </div>
        <div class="tab-pane" id="reworks">
            <?=Reworks::widget(['task' => $model]);?>
        </div>
        
        <?php if(!yii::$app->user->isCustomer()) { ?>
            <div class="tab-pane" id="members">
                <?=Members::widget(['task' => $model]);?>
            </div>
        <?php } ?>

        <div class="tab-pane actions_list" id="actions">
            <?php if(!empty($model->actions)) { ?>
                <ul>
                    <?php
                    foreach($model->actions as $action) {
                        echo "<li><b>{$action->username}</b> [<small>".date('d.m.Y H:i:s', $action->time)."</small>]: {$action->text}</li>";
                    }
                    ?>
                </ul>
            <?php } ?>
        </div>
        <div class="tab-pane" id="accesses">
            <pre><?php echo yii::$app->prettytext->setText($model->accesses)->links()->getText(); ?></pre>
        </div>

        <div class="tab-pane" id="discussion">
            <?php echo \yii2mod\comments\widgets\Comment::widget([
                'model' => $model,
            ]); ?>
        </div>
    </div>
</div>
