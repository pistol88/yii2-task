<?php
namespace pistol88\task;

use pistol88\task\models\TaskToUser;
use pistol88\task\models\Task;
use pistol88\task\models\Rework;
use yii\base\Component;
use yii;

class Rework extends Component {
    
    public function userAccess(\pistol88\task\models\Rework $rework, $member)
    {
        return TaskToUser::find()->where(['task_id' => $rework->task->id, 'user_id' => $member->id])->one();
    }
    
    public function get($id)
    {
        $rework = Rework::findOne($id);
        
        if(yii::$app->task->userAccess($rework->task, yii::$app->user->member)) {
            return $rework;
        }
        
        return null;
    }
    
    public function setPayment(\pistol88\task\models\Rework $rework, $payment)
    {
        $rework->payment = $payment;
        
        return $rework->save();
    }
    
    public function setStatus(\pistol88\task\models\Rework $rework, $status)
    {
        $rework->status = $status;
        
        return $rework->save();
    }
    
    public function setPrice(\pistol88\task\models\Rework $rework, $price)
    {
        $rework->price = $price;
        
        return $rework->save();
    }
    
    public function setDeadline(\pistol88\task\models\Rework $rework, $deadline)
    {
        $rework->deadline = $deadline;
        
        return $rework->save();
    }
    
    public function setPerfomer(\pistol88\task\models\Rework $rework, $perfomer)
    {
        $rework->perfomer_id = $perfomer;
        
        return $rework->save();
    }
    
    public function setPerfomerPayment(\pistol88\task\models\Rework $rework, $payment)
    {
        $rework->payment_perfomer = $payment;
        
        return $rework->save();
    }
}