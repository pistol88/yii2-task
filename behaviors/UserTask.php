<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\task\models\Task;
use pistol88\task\models\Rework;
use pistol88\task\models\TaskToUser;

class UserTask extends Behavior
{
    public function isCustomer()
    {
        if($this->owner->getStaffer()) {
            return false;
        }
        
        return true;
    }
    
    public function isStaffer()
    {
        if($this->owner->getStaffer()) {
            return true;
        }
        
        return false;
    }
    
    public function getTasks()
    {
        $model = $this->owner->getStaffer();

        $model = $model->hasMany(
                Task::className(),
                ['id' => 'task_id']
            )
            ->viaTable('task_to_user', ['user_id' => 'id']);
    
        return $model;
    }
    
    public function getReworks()
    {
        
        
        if(!yii::$app->user->isCustomer() && !yii::$app->user->isManager()) {
            $model = $this->owner->getStaffer();
            
            return Rework::find()->where(['perfomer_id' => $model->id]);
        }
    
        return Rework::find();
    }
    
    public function isManager()
    {
        $stafferModel = $this->owner->getStaffer();
        
        if(!$stafferModel) {
            return false;
        }
        
        foreach(yii::$app->task->roleToCategory as $role => $categoryIds) {
            foreach($categoryIds as $id) {
                if($stafferModel->category_id == $id && $role == 'manager') {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function isDeveloper()
    {
        $stafferModel = $this->owner->getStaffer();
        
        if(!$stafferModel) {
            return false;
        }
        
        foreach(yii::$app->task->roleToCategory as $role => $categoryIds) {
            foreach($categoryIds as $id) {
                if($stafferModel->category_id == $id && $role == 'developer') {
                    return true;
                }
            }
        }
        
        return false;
    }
}
