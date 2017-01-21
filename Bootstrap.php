<?php
namespace pistol88\task;

use yii\base\BootstrapInterface;
use yii\helpers\Url;
use yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($application)
    {
        
        yii::$app->on('beforeAction', function($event) {
            if(yii::$app->user) {
                yii::$app->user->attachBehavior('taskStaffer', 'pistol88\task\behaviors\UserStaffer');
                yii::$app->user->attachBehavior('taskClient', 'pistol88\task\behaviors\UserClient');
                yii::$app->user->attachBehavior('task', 'pistol88\task\behaviors\UserTask');
            }
        });
        
        yii::$app->view->on('endBody', function() {
            echo "<script>var dvizhTaskToolsUrl = '".Url::toRoute(['/task/widget/multi-widget', 'widget' => ''])."';</script>";
            echo "<script>var dvizhUrl = '".yii::$app->request->baseUrl."';</script>";
        });
        
        if(!$application->has('task')) {
            $application->set('task', [
                'class' => '\pistol88\task\Task',
            ]);
        }
        
        if(!$application->has('rework')) {
            $application->set('rework', [
                'class' => '\pistol88\task\Rework',
            ]);
        }
        
        if(!$application->has('prettytext')) {
            $application->set('prettytext', [
                'class' => '\pistol88\task\components\PrettyText',
            ]);
        }
        
        if(empty($application->modules['gridview'])) {
            $application->setModule('gridview', [
                'class' => '\kartik\grid\Module',
            ]);
        }
    }
}