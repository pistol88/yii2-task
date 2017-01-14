<?php
namespace pistol88\task\behaviors;

use yii;
use yii\base\Behavior;
use pistol88\client\models\Client;

class UserClient extends Behavior
{
    public function getClient()
    {
        return Client::find()->where(['user_id' => $this->owner->id])->one();
    }
}
