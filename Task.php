<?php
namespace pistol88\task;

use yii\base\Component;
use yii;

class Task extends Component {
    public $notDevelopersRoles = [
        'user', 'superadmin', 'administrator'
    ];
    
    public $statuses = [
        "active" => 'Активно',
        "wait" => 'Ожидание З',
        "wait_customer" => 'Ожидание оценки',
        "done" => 'Выполнено',
        "expired" => 'Сроки истекли',
        "close" => 'Сдано',
        "stop" => 'Приостановлено',
        "money" => 'Ожидание оплаты',
        "deleted" => 'Удалено'
    ];
    
    public function isManager()
    {
        
    }
    
    public function isCustomer()
    {
        
    }
    
    public function isDeveloper()
    {
        
    }
}