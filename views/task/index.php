<?php
use yii\helpers\Url;
use yii\helpers\Html;
use pistol88\task\assets\TaskAsset;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

TaskAsset::register($this);

$this->title = 'Задачи';

if($project) {
    $this->params['breadcrumbs'][] = ['label' => yii::$app->task->projectsNames['many'], 'url' => '/task/project/index'];
    $this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => Url::toRoute(['/task/task/index', 'TaskSearch' => ['project_id' => $project->id]])];
} else {
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="task-index">
    
    <div class="row">
        <div class="col-md-3">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-9">

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
                    if($project = $model->project) {
                        $project = "<a href=\"".Url::toRoute(['task/index', 'TaskSearch' => ['project_id' => $project->id]])."\">".$project->name."</a>";
                    } else {
                        $project = '';
                    }
                    
                    return " $project / <a href=\"".Url::toRoute(['task/view', 'id' => $model->id])."\"><strong>".$model->name."</strong></a>";
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
                    $reworks = $model->getReworks();
                    
                    if(yii::$app->user->isDeveloper()) {
                        return $reworks->andWhere(['status' => ['wait', 'active', 'expired']])->count();
                    } elseif(yii::$app->user->isCustomer()) {
                        return $reworks->andWhere(['status' => ['wait', 'wait_customer', 'active', 'expired']])->count();
                    } elseif(yii::$app->user->isManager()) {
                        return $reworks->andWhere(['status' => ['wait', 'wait_customer', 'active', 'expired', 'stop']])->count();
                    }
                    
                    return $reworks->count();
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

