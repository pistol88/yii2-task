<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Rework */

$this->title = 'Create Rework';
$this->params['breadcrumbs'][] = ['label' => 'Reworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rework-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
