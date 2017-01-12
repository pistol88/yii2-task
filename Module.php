<?php
namespace pistol88\task;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'administrator', 'superadmin'];
    
    public function init()
    {
        $model = yii::$app->user->getIdentity()->attachBehavior('tasks', 'pistol88\task\behaviors\UserTask');
        
        parent::init();
    }
}