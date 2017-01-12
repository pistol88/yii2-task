<?php
namespace pistol88\task;

use yii\base\BootstrapInterface;
use yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(!$app->has('task')) {
            $app->set('task', [
                'class' => '\pistol88\task\Task',
            ]);
        }
        
        if(!$app->has('prettytext')) {
            $app->set('prettytext', [
                'class' => '\pistol88\task\components\PrettyText',
            ]);
        }
        
        if(empty($app->modules['gridview'])) {
            $app->setModule('gridview', [
                'class' => '\kartik\grid\Module',
            ]);
        }
    }
}