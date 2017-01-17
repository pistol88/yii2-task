<?php
namespace pistol88\task\widgets;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii;

class ReworkPayment extends \yii\base\Widget
{
    public $rework = null;

    public function init()
    {
        \pistol88\task\assets\AjaxWidgets::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return $this->render('rework_payment', [
            'rework' => $this->rework,
        ]);
    }
}
