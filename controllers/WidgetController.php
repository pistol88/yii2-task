<?php

namespace pistol88\task\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use pistol88\task\widgets\Members;
use pistol88\task\widgets\Rework;
use pistol88\task\widgets\TaskHeader;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class WidgetController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'multi-widget' => ['POST'],
                ],
            ],
        ];
    }

    public function actionMultiWidget($widget)
    {
        if($taskId = yii::$app->request->post('task_id')) {
            $task = yii::$app->task->get($taskId);
            $rework = false;
            $taskId = $task->id;
            $reworkId = false;
        } elseif($reworkId = yii::$app->request->post('rework_id')) {
            $rework = yii::$app->rework->get($reworkId);
            $task = $rework->task;
            $taskId = $task->id;
            $reworkId = $rework->id;
        }
        
        switch($widget) {
            case 'change_payment':
                yii::$app->task->setPayment($task, yii::$app->request->post('payment'));
                break;
            case 'change_status':
                yii::$app->task->setStatus($task, yii::$app->request->post('status'));
                break;
            case 'change_price':
                yii::$app->task->setPrice($task, yii::$app->request->post('price'));
                break;
            case 'change_deadline':
                yii::$app->task->setDeadline($task, yii::$app->request->post('deadline'));
                break;
            case 'change_user_price':
                yii::$app->task->setMemberPrice($task, yii::$app->request->post('price'), yii::$app->request->post('user_id'));
                break;
            case 'change_user_status':
                yii::$app->task->setMemberStatus($task, yii::$app->request->post('status'), yii::$app->request->post('user_id'));
                break;
            case 'change_user_deadline':
                yii::$app->task->setMemberDeadline($task, yii::$app->request->post('deadline'), yii::$app->request->post('user_id'));
                break;
            case 'change_user_payment':
                yii::$app->task->setMemberPayment($task, yii::$app->request->post('payment'), yii::$app->request->post('user_id'));
                break;
            case 'reworks_change_status':
                yii::$app->rework->setStatus($rework, yii::$app->request->post('status'));
                break;
            case 'reworks_change_deadline':
                yii::$app->rework->setDeadline($rework, yii::$app->request->post('deadline'));
                break;
            case 'reworks_change_price':
                yii::$app->rework->setPrice($rework, yii::$app->request->post('price'));
                break;
            case 'reworks_change_payment':
                yii::$app->rework->setPayment($rework, yii::$app->request->post('payment'));
                break;
            case 'reworks_change_perfomer':
                yii::$app->rework->setPerfomer($rework, yii::$app->request->post('perfomer'));
                break;
            case 'reworks_change_payment_perfomer':
                yii::$app->rework->setPerfomerPayment($rework, yii::$app->request->post('payment'));
                break;
        }
        
        if($task) {
            $htmlData = '';
            
            if($rework) {
                $htmlData = Rework::widget(['rework' => $rework]);
            }
            
            return json_encode(['reworkId' => $reworkId, 'taskId' => $taskId, 'htmlData' => $htmlData, 'result' => 'success', 'membersWidgetHtml' => Members::widget(['task' => $task]), 'taskHeaderWidgetHtml' => TaskHeader::widget(['task' => $task]),]);
        }
    }
}
