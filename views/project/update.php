<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Project */

$this->title = 'Редактировать '.yii::$app->task->projectsNames['one'].': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => yii::$app->task->projectsNames['many'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
