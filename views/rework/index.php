<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\task\models\tools\ReworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reworks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rework-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rework', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text:ntext',
            'date_start',
            'date_deadline',
            'task_id',
            // 'perfomer_id',
            // 'status',
            // 'price',
            // 'number',
            // 'payment',
            // 'payment_perfomer',
            // 'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
