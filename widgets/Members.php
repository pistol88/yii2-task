<?php
namespace pistol88\task\widgets;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii;

class Members extends \yii\base\Widget
{
    public $task = null;

    public function init()
    {
        \pistol88\task\assets\MembersAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return $this->render('members', [
            'model' => $this->task,
        ]);
    }
}
