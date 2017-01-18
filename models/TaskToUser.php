<?php

namespace pistol88\task\models;

use Yii;

/**
 * This is the model class for table "task_to_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property integer $project_id
 * @property integer $price
 * @property string $status
 * @property string $deadline
 * @property string $payment
 */
class TaskToUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id',], 'required'],
            [['user_id', 'task_id', 'project_id', 'price'], 'integer'],
            [['status', 'payment'], 'string'],
            [['deadline'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Участник',
            'task_id' => 'Задача',
            'project_id' => 'Проект',
            'price' => 'Оценка',
            'status' => 'Статус',
            'deadline' => 'Дедлайн',
            'payment' => 'Оплата',
        ];
    }
    
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['id' => 'task_id']);
    }
    
    public function getPayment_type_id()
    {
        return 0;
    }
    
    public function getCost()
    {
        return $this->price;
    }
}
