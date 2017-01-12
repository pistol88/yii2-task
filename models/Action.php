<?php

namespace pistol88\task\models;

use Yii;

/**
 * This is the model class for table "task_action".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $text
 * @property integer $time
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'project_id', 'user_id', 'text', 'time'], 'required'],
            [['task_id', 'project_id', 'user_id', 'time'], 'integer'],
            [['text'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'time' => 'Time',
        ];
    }
    
    public function getUsername()
    {
        if($user = $this->user) {
            return $user->username;
        }
        
        return null;
    }
    
    public function getUser()
    {
        $userModel = yii::$app->user->getIdentity();
        
        return $this->hasOne($userModel::className(), ['id' => 'user_id']);
    }
}
