<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\task\models\Task;
use pistol88\task\models\TaskToUser;

class TaskMember extends Behavior
{
    public function isCustomer()
    {
        $owner = $this->owner;
        if($owner::className() == 'pistol88\client\models\Client') {
            return true;
        }
        
        return false;
    }
    
    public function isStaffer()
    {
        $owner = $this->owner;
        if($owner::className() == 'pistol88\staffer\models\Staffer') {
            return true;
        }
        
        return false;
    }
    
    public function getTaskRole()
    {

        foreach(yii::$app->task->roleToCategory as $role => $categoryIds) {
            foreach($categoryIds as $id) {
                if($this->owner->category_id == $id) {
                    return $role;
                }
            }
        }
        
        return null;
    }
    
    public function getTaskType()
    {
        if(!$this->isStaffer()) {
            return 'customer';
        } else {
            return 'staffer';
        }
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
        $taskToUser = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $this->owner->user->id]);
        
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
            return $taskToUser->status;
        }
    }

    public function isDeveloper()
    {
        foreach(yii::$app->task->roleToCategory as $role => $categoryIds) {
            foreach($categoryIds as $id) {
                if($this->owner->category_id == $id && $role == 'developer') {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function isManager()
    {
        foreach(yii::$app->task->roleToCategory as $role => $categoryIds) {
            foreach($categoryIds as $id) {
                if($this->owner->category_id == $id && $role == 'manager') {
                    return true;
                }
            }
        }
        
        return false;
    }
}