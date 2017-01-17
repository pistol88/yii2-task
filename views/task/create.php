<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Task */

$this->title = 'Добавление задачи';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
