<?php
use yii\helpers\Url;
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
            <div class="task-menu">
                <div class="menu-container">
                <ul class="nav-pills pull-right nav">
                    <li><a href="<?=Url::toRoute(['/task/task/index']);?>">Задачи</a></li>
                    <li><a href="<?=Url::toRoute(['/task/project/index']);?>">Проекты</a></li>
                    <li><a href="<?=Url::toRoute(['/task/arrears/index']);?>">Долги</a></li></ul>
                </div>
            </div>
        </div>
    </div>  


    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'export'=>[
            'fontAwesome'=>true
        ],
        'bordered' => 1,
        'striped' => 1,
        'condensed' => 1,
        'responsive' => 1,
        'columns' => [
            [
                'attribute' => 'name',
                'content' => function($model) {
                    return "<a href=\"".Url::toRoute('task/view', ['id' => $model->id])."\"><strong>".$model->name."</strong></a>";
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
                    $color = '#fff';
                    if($model->status == 'active') {
                        $color = '#e3ece3';
                    } elseif($model->status == 'expired') {
                        $color = '#eacaca';
                    }
                    
                    return "<span style=\"padding: 4px; background-color: $color;\">".yii::$app->task->statuses[$model->status]."</span>";
                }
            ],
            [
                'label' => 'Доработки',
                'content' => function($model) {
                    return $model->getReworks()->count();
                }
            ],
            'project.name',
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

