<?php

namespace pistol88\task\controllers;

use Yii;
use pistol88\task\models\Task;
use pistol88\task\models\tools\TaskSearch;
use pistol88\task\widgets\Members;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                    'delete' => ['POST'],
                    'add-new-member' => ['POST'],
                    'remove-member' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, yii::$app->user->getTasks());
        
        if(yii::$app->user->isDeveloper()) {
            $dataProvider->query->andWhere(['status' => ['wait', 'active', 'expired']]);
        } elseif(yii::$app->user->isCustomer()) {
            $dataProvider->query->andWhere(['status' => ['wait', 'active', 'expired', 'wait_customer']]);
        } else {
            $dataProvider->query->andWhere(['status' => ['wait', 'active', 'expired', 'wait_customer']]);
        }
        
        $project = false;
        
        if($taskSearch = Yii::$app->request->get('TaskSearch')) {
            if(isset($taskSearch['project_id'])) {
                $projectId = $taskSearch['project_id'];
                $project = yii::$app->task->getProject($projectId);
            }
        }
        
        if(!Yii::$app->request->get('sort')) {
            $dataProvider->query->orderBy('last_action DESC, id DESC');
        }
        
        return $this->render('index', [
            'project' => $project,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRemoveMember($taskId, $memberId)
    {
        $task = $this->findModel($taskId);
        
        if(yii::$app->task->removeMemberById($task, $memberId)) {
            $status = 'success';
        } else {
            return $status = 'fail';
        }

        return json_encode(['result' => $status, 'membersWidgetHtml' => Members::widget(['task' => $this->findModel($taskId)])]);
    }
    
    public function actionAddNewMember($taskId)
    {
        $task = $this->findModel($taskId);
        
        $data = yii::$app->request->post();
        
        if(isset($data['clients']) && !empty($data['clients'])) {
            foreach($data['clients'] as $clientId) {
                $client = yii::$app->client->get($clientId);
                if($client = yii::$app->client->get($clientId)) {
                    yii::$app->task->addClient($task, $client);
                }
            }
        }
        
        if(isset($data['staffers']) && !empty($data['staffers'])) {
            foreach($data['staffers'] as $stafferId) {
                if($staffer = yii::$app->staffer->get($stafferId)) {
                    yii::$app->task->addStaffer($task, $staffer);
                }
            }
        }
        
        return json_encode(['result' => 'success', 'membersWidgetHtml' => Members::widget(['task' => $this->findModel($taskId)])]);
    }
    
    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project = null)
    {
        $model = new Task();
        
        $model->payment = 'no';
        $model->status = 'wait';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $project = yii::$app->task->getProject($project);

            if(!$project) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            $model->project_id = $project->id;
            
            return $this->render('create', [
                'model' => $model,
                'project' => $project,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $project = $model->project;
            
            $model->date_deadline = yii::$app->task->dateFormat($model->date_deadline);
            
            return $this->render('update', [
                'project' => $project,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = yii::$app->task->get($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
