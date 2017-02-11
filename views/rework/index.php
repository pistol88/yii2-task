<?php

use yii\helpers\Html;
use yii\grid\GridView;
use pistol88\task\widgets\ReworkStatus;
use pistol88\task\widgets\ReworkDeadline;
use pistol88\task\widgets\ReworkPrice;
use pistol88\task\assets\TaskAsset;

TaskAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\ReworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доработки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rework-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'task.project.name',
            [
                'attribute' => 'text',
                'content' => function($model) {
                    if($task = $model->task) {
                        $taskName = $task->name;
                    } else {
                        $taskName = '';
                    }
                    return '<strong>'.$taskName.'</strong> / '.mb_substr($model->text, 0, 1000, 'UTF-8');
                }
            ],
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    yii::$app->task->statuses,
                    ['class' => 'form-control', 'prompt' => 'Статус']
                ),
                'content' => function($model) {
                    return ReworkStatus::widget(['rework' => $model]);
                },
                'options' => ['style' => 'width: 150px;']
            ],
            [
                'attribute' => 'price',
                'content' => function($model) {
                    return ReworkPrice::widget(['rework' => $model]);
                }
            ],
            [
                'attribute' => 'date_deadline',
                'content' => function($model) {
                    return ReworkDeadline::widget(['rework' => $model]);
                }
            ],

            'perfomer.name',
            //['class' => 'yii\grid\ActionColumn', 'template' => '{update}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 50px;']],
        ],
    ]); ?>
</div>
