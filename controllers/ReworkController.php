<?php

namespace pistol88\task\controllers;

use Yii;
use pistol88\task\models\Rework;
use pistol88\task\models\tools\ReworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ReworkController implements the CRUD actions for Rework model.
 */
class ReworkController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Rework models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReworkSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, yii::$app->user->getReworks());
        
        if(yii::$app->user->isDeveloper()) {
            $dataProvider->query->andWhere(['status' => ['wait', 'active', 'expired']]);
        } elseif(yii::$app->user->isCustomer()) {
            $dataProvider->query->andWhere(['status' => ['wait', 'wait_customer', 'active', 'expired']]);
        } elseif(yii::$app->user->isManager()) {
            $dataProvider->query->andWhere(['status' => ['wait', 'wait_customer', 'active', 'expired', 'stop']]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rework model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAdd()
    {
        $model = new Rework();

        $data = yii::$app->request->post();
        
        $task = $this->findModel($data['task_id']);

		$json = ['result' => 'success'];
		
        $reworksList = $data['rework_list'];
        $newList = preg_split('/\n\d+[\.\)]/Usi', str_replace("\r", '', "\n".$reworksList."\n"));
			
        if(empty($newList[0])) {
            unset($newList[0]);
        }

        $increment = yii::$app->rework->getTaskAutoincrement($task);

        foreach($newList as $text) {
            $reworkData = array(
                'text' => trim(htmlspecialchars($text)),
                'task_id' => $task->id,
                'status' => $data['rework_status'],
                'perfomer_id' => (int)$data['perfomer_id'],
                'date_start' => date('Y-m-d H:i:s'),
                'deadline' => $data['deadline'];
                'number' => $increment,
            );
            
            yii::$app->task->addRework($task, $reworkData);
            $increment++;
        }

		die(json_encode($json));
    }
    
    /**
     * Updates an existing Rework model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rework model.
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
     * Finds the Rework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rework the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = yii::$app->rework->get($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
