<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\ReworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доработки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rework-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    yii::$app->task->statuses,
                    ['class' => 'form-control', 'prompt' => 'Статус']
                ),
                'content' => function($model) {
                    return yii::$app->task->statuses[$model->status];
                }
            ],
            [
                'attribute' => 'text',
                'content' => function($model) {
                    return mb_substr($model->text, 0, 100, 'UTF-8');
                }
            ],
            'date_deadline',
            'task.project.name',
            'task.name',
            'perfomer.name',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 150px;']],
        ],
    ]); ?>
</div>
