<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Rework */

$this->title = "Доработка ".$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['/task/index/index']];

if($task = $model->task) {
    if($project = $task->project) {
        $this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => Url::toRoute(['/task/task/index', 'TaskSearch' => ['project_id' => $project->id]])];
    }
    
    $this->params['breadcrumbs'][] = ['label' => $task->name, 'url' => Url::toRoute(['/task/task/view', 'id' => $task->id])];
}

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="rework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rework_text"><?php echo nl2br(yii::$app->prettytext->setText($model->text)->links()->getText()); ?></div>
    
    <div class="rework_disquss">
        <?php echo \yii2mod\comments\widgets\Comment::widget([
            'model' => $model,
        ]); ?>
    </div>
    
</div>
