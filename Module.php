<?php
namespace pistol88\task;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'administrator', 'superadmin'];
    
    public function init()
    {
        parent::init();
    }
}