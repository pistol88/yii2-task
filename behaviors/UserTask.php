<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\task\models\Task;

class UserTask extends Behavior
{
    public function getTasks()
    {
        $model = $this->owner;
        
        $model = $model->hasMany(
                Task::className(),
                ['id' => 'task_id']
            )
            ->viaTable('task_to_user', ['user_id' => 'id']);
    
        return $model;
    }
    
    public function getRole()
    {
        if($roles = Yii::$app->authManager->getRolesByUser($this->owner->id)) {
            if($role = current($roles)) {
                return $role->name;
            }
        }
        
        return false;
    }
    
    public function getType()
    {
        return 'staffer';
    }
}
