<?php

namespace pistol88\task\models;

use pistol88\task\models\tools\TaskQuery;
use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $project_id
 * @property string $description
 * @property string $date_start
 * @property string $date_deadline
 * @property integer $price
 * @property string $accesses
 * @property string $status
 * @property string $payment
 * @property integer $haron_user_id
 * @property integer $updated
 * @property string $members_data
 * @property string $members
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    public static function find()
    {
        $taskQuery = new TaskQuery(get_called_class());
        
        return $taskQuery->with('stafferRelation')->with('clientRelation')->with('reworks');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'project_id', 'description', 'status'], 'required'],
            [['project_id', 'price', 'haron_user_id', 'updated'], 'integer'],
            [['description', 'accesses', 'status', 'payment', 'date_deadline'], 'string'],
            [['date_start', 'date_deadline'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'project_id' => 'Проект',
            'description' => 'Описание',
            'date_start' => 'Дата начала',
            'date_deadline' => 'Дедлайн',
            'price' => 'Стоимость',
            'accesses' => 'Доступы',
            'status' => 'Статус',
            'payment' => 'Оплачено',
            'haron_user_id' => 'Создатель',
            'updated' => 'Обновлено',
            'members_data' => 'Данные подключенных',
            'last_action' => 'Последнее действие',
        ];
    }
    
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
    
    public function getReworks()
    {
        return $this->hasMany(Rework::className(), ['task_id' => 'id'])->where(['!=', 'status', 'delete']);
    }
    
    public function getMembers()
    {
        $staffers = $this->getStaffers();
        $clients = $this->getClients();
        $members = [];
        
        foreach($staffers as $staffer) {
            $members[] = $staffer;
        }
        
        foreach($clients as $client) {
            $members[] = $client;
        }
        
        return $members;
    }
    
    public function getStafferRelation()
    {
        return $this->hasMany('pistol88\staffer\models\Staffer', ['id' => 'user_id'])->viaTable('task_to_user', ['task_id' => 'id']);
    }
    
    public function getClientRelation()
    {
        return $this->hasMany('pistol88\client\models\Client', ['id' => 'user_id'])->viaTable('task_to_user', ['task_id' => 'id']);
    }
    
    public function getStaffers()
    {
        $staffers = $this->stafferRelation;
        
        foreach($staffers as $staffer) {
            $staffer->attachBehavior('tasks', 'pistol88\task\behaviors\TaskMember');
        }
        
        return $staffers;
    }
    
    public function getClients()
    {
        $clients = $this->clientRelation;
        
        foreach($clients as $client) {
            $client->attachBehavior('tasks', 'pistol88\task\behaviors\TaskMember');
        }
        
        return $clients;
    }
    
    public function getEndprice()
    {
        return ceil($this->price*2);
    }
    
    public function getActions()
    {
        return $this->hasMany(Action::className(), ['task_id' => 'id']);
    }
    
    public function getPayment_type_id()
    {
        return 0;
    }
    
    public function getCost()
    {
        return $this->price;
    }
    
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        
        if(!$this->date_start) {
            $this->date_start = date('Y-m-d H:i:s');
        }
        
        if(!$this->haron_user_id) {
            $this->haron_user_id = yii::$app->user->member->id;
        }
        
        return true;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
     
        if(!$this->accesses && $this->project && $insert) {
            $this->accesses = $this->project->accesses;
            $this->save(false);
        }
        
        yii::$app->task->addStaffer($this, yii::$app->user->member);
     
        return true;
    }
}
