<?php
namespace pistol88\task;

use yii\base\Component;
use yii;

class Task extends Component {
    public $stafferModel = 'pistol88\staffer\models\Staffer';
    
    public $notDevelopersRoles = [
        'user', 'superadmin', 'administrator'
    ];
    
    public $roleToCategory = [
        'manager' => [219, 217],
        'developer' => [214, 215, 216, 218],
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
}