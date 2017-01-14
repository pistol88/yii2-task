<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\task\models\Task;
use pistol88\task\models\TaskToUser;

class UserTask extends Behavior
{
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
    
    public function getRole()
    {
        return $this->owner->category_id;
    }
    
    public function getType()
    {
        return 'staffer';
    }
    
    public function getTaskPrice($task)
    {
        $taskToUser = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $this->owner->id]);
        
        if($taskToUser) {
            return $taskToUser->price;
        }
    }
    
    public function getTaskDeadline($task)
    {
        $taskToUser = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $this->owner->id]);
        
        if($taskToUser) {
            return $taskToUser->deadline;
        }
    }
    
    public function getTaskPayment($task)
    {
        $taskToUser = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $this->owner->id]);
        
        if($taskToUser) {
            return $taskToUser->payment;
        }
    }
    
    public function getTaskStatus($task)
    {
        $taskToUser = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $this->owner->id]);
        
        if($taskToUser) {
            return $taskToUser->payment;
        }
    }
    
    public function isCustomer()
    {
        if($this->owner->client) {
            return true;
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
}
