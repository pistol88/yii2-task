<?php
namespace pistol88\task\widgets;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii;

class MemberPrice extends \yii\base\Widget
{
    public $task = null;
    public $member = null;

    public function init()
    {
        \pistol88\task\assets\AjaxWidgets::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return $this->render('member_price', [
            'model' => $this->task,
            'member' => $this->member,
        ]);
    }
}
