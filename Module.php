<?php
namespace pistol88\task;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'administrator', 'superadmin'];
    
    public function init()
    {
        yii::$app->user->getIdentity()->attachBehavior('taskStaffer', 'pistol88\task\behaviors\UserStaffer');
        yii::$app->user->getIdentity()->attachBehavior('taskClient', 'pistol88\task\behaviors\UserClient');
        yii::$app->user->getIdentity()->attachBehavior('task', 'pistol88\task\behaviors\UserTask');
        
        parent::init();
    }
}