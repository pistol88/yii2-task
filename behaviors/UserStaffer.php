<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\staffer\models\Staffer;

class UserStaffer extends Behavior
{
    public function getStaffer()
    {
        return Staffer::find()->where(['user_id' => $this->owner->id])->one();
    }
}
