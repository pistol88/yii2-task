<?php
namespace pistol88\task\widgets;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii;

class Rework extends \yii\base\Widget
{
    public $rework = null;

    public function init()
    {
        \pistol88\task\assets\ReworksAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return $this->render('rework', [
            'rework' => $this->rework,
        ]);
    }
}
