<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Rework */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text:ntext',
            'date_start',
            'date_deadline',
            'task_id',
            'perfomer_id',
            'status',
            'price',
            'number',
            'payment',
            'payment_perfomer',
            'comment:ntext',
        ],
    ]) ?>

</div>
