<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Rework */

$this->title = 'Update Rework: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rework-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
