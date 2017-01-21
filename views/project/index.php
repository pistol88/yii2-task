<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = yii::$app->task->projectsNames['many'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить '.yii::$app->task->projectsNames['one'], ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=  \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            [
                'label' => 'Задачи',
                'content' => function($model) {
                    $return =  Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['/task/task/index', 'TaskSearch' => ['project_id' => $model->id]], ['class' => 'btn btn-default', 'title' => 'Смотреть']);
                    return  $return . ' ' . Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/task/task/create', 'project' => $model->id], ['class' => 'btn btn-success', 'title' => 'Добавить']);
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 150px;']],
        ],
    ]); ?>
</div>
