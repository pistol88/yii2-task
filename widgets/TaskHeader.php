<?php
namespace pistol88\task\widgets;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii;

class TaskHeader extends \yii\base\Widget
{
    public $task = null;

    public function init()
    {
        \pistol88\task\assets\TaskAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return $this->render('task_header', [
            'model' => $this->task,
        ]);
    }
}
