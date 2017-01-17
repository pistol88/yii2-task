<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model pistol88\task\models\Project */

$this->title = 'Добавить сайт';
$this->params['breadcrumbs'][] = ['label' => 'Сайты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
