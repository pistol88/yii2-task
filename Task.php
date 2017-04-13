<?php
namespace pistol88\task;

use pistol88\task\models\TaskToUser;
use pistol88\task\models\Project;
use pistol88\task\models\Task as TaskModel;
use pistol88\task\models\Rework as ReworkModel;
use yii\base\Component;
use yii;

class Task extends Component {
    
    public $projectsNames = [
        'one' => 'Сайт',
        'many' => 'Сайты',
    ];
    
    public $notDevelopersRoles = [
        'user', 'superadmin', 'administrator'
    ];
    
    public $roleToCategory = [
        'manager' => [219, 217],
        'developer' => [214, 215, 216, 218],
    ];
    
    public $statuses = [
        "active" => 'Активно',
        "wait" => 'Ожидание оценки',
        "wait_customer" => 'Ожидание З',
        "done" => 'Выполнено',
        "expired" => 'Сроки истекли',
        "close" => 'Сдано',
        "stop" => 'Приостановлено',
        "money" => 'Ожидание оплаты',
        "deleted" => 'Удалено'
    ];
    
    public function getProject($projectId)
    {
        return Project::findOne($projectId);
    }
    
    public function userAccess(\pistol88\task\models\Task $task, $member)
    {
        return TaskToUser::find()->where(['task_id' => $task->id, 'user_id' => $member->id])->one();
    }
    
    public function addRework($task, $reworkData)
    {
        $rework = new ReworkModel;
        $rework->text = $reworkData['text'];
        $rework->task_id = $task->id;
        $rework->number = $reworkData['number'];
        $rework->status = $reworkData['status'];
        $rework->perfomer_id = $reworkData['perfomer_id'];
        $rework->date_start = $reworkData['date_start'];
        
        return $rework->save();
    }
    
    public function addStaffer(\pistol88\task\models\Task $task, \pistol88\staffer\models\Staffer $staffer)
    {
        if(!$this->userAccess($task, $staffer)) {
            $taskToUser = new TaskToUser;
            $taskToUser->task_id = $task->id;
            $taskToUser->user_id = $staffer->id;

            return $taskToUser->save(false);
        }
    }
    
    public function addClient(\pistol88\task\models\Task $task, \pistol88\client\models\Client $client)
    {
        if(!$this->userAccess($task, $client)) {
            $taskToUser = new TaskToUser;
            $taskToUser->task_id = $task->id;
            $taskToUser->user_id = $client->id;
            
            return $taskToUser->save(false);
        }
    }
    
    public function removeMemberById(\pistol88\task\models\Task $task, $clientId)
    {
        if($relation = TaskToUser::find()->where(['task_id' => $task->id, 'user_id' => $clientId])->one()) {
            return $relation->delete();
        }
        
        return false;
    }
    
    public function get($id)
    {
        $task = TaskModel::findOne($id);
        
        if($this->userAccess($task, yii::$app->user->member)) {
            return $task;
        }
        
        return null;
    }
    
    public function setPayment(\pistol88\task\models\Task $task, $payment)
    {
        $task->payment = $payment;
        
        return $task->save(false);
    }
    
    public function setStatus(\pistol88\task\models\Task $task, $status)
    {
        $task->status = $status;
        
        return $task->save(false);
    }
    
    public function setPrice(\pistol88\task\models\Task $task, $price)
    {
        $task->price = $price;

        return $task->save(false);
    }
    
    public function setDeadline(\pistol88\task\models\Task $task, $deadline)
    {
        $task->date_deadline = date('Y-m-d', strtotime($deadline));

        return $task->save(false);
    }
    
    public function setMemberPayment(\pistol88\task\models\Task $task, $payment, $member)
    {
        $taskMember = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $member]);
        
        if($taskMember) {
            $taskMember->payment = $payment;
            return $taskMember->save(false);
        } else {
            return false;
        }
    }
    
    public function setMemberStatus(\pistol88\task\models\Task $task, $status, $member)
    {
        $taskMember = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $member]);
        
        if($taskMember) {
            $taskMember->status = $status;
            return $taskMember->save(false);
        } else {
            return false;
        }
    }
    
    public function setMemberPrice(\pistol88\task\models\Task $task, $price, $member)
    {
        $taskMember = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $member]);
        
        if($taskMember) {
            $taskMember->price = $price;
            return $taskMember->save(false);
        } else {
            return false;
        }
    }
    
    public function setMemberDeadline(\pistol88\task\models\Task $task, $deadline, $member)
    {
        $taskMember = TaskToUser::findOne(['task_id' => $task->id, 'user_id' => $member]);
        
        if($taskMember) {
            $taskMember->deadline = $deadline;
            return $taskMember->save(false);
        } else {
            return false;
        }
    }
    
    public function dateFormat($date)
    {
        if($date == '0000-00-00' | $date == '1970-01-01' | $date == '01.01.1970') {
            return '';
        }
        else {
            return date('d.m.Y', strtotime($date));
        }
    }

    public function getByStatus($status, $payment = null)
    {
        $tasks = TaskModel::find()->where(['status' => $status]);

        if($payment) {
            $tasks->andWhere(['payment' => $payment]);
        }

        return $tasks->all();
    }
}
