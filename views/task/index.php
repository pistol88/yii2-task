<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
    
    <div class="row">
        <div class="col-md-3">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-9">

        </div>
    </div>  


    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'toolbar'=> [
            ['content'=>
                Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
            ],
            '{export}',
            '{toggleData}',
        ],
        // set export properties
        'export'=>[
            'fontAwesome'=>true
        ],
        // parameters from the demo form
        'bordered' => 1,
        'striped' => 1,
        'condensed' => 1,
        'responsive' => 1,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
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
            'project.name',
            [
                'attribute' => 'date_start',
                'content' => function($model) {
                    return date('d.m.Y', strtotime($model->date_start));
                }
            ],
            [
                'attribute' => 'date_deadline',
                'content' => function($model) {
                    if(!$model->date_deadline == '0000-00-00') {
                        return '-';
                    }
                    
                    $date = date('d.m.Y', strtotime($model->date_deadline));
                    
                    if($date == '01.01.1970') {
                        return '-';
                    }
                    
                    return $date;
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 50px;']],
        ],
    ]); ?>

</div>

