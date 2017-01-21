<?php
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Task */

$this->title = 'Добавление задачи';
$this->params['breadcrumbs'][] = ['label' => yii::$app->task->projectsNames['many'], 'url' => ['/task/project/index']];
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => Url::toRoute(['/task/task/index', 'TaskSearch' => ['project_id' => $project->id]])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'project' => $project,
    ]) ?>

</div>
