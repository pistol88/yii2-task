<?php
namespace pistol88\task\models\tools;

use yii;

class TaskQuery extends \yii\db\ActiveQuery
{
    public function status($status)
    {
        return $this->where(['status' => $status]);
    }
    
    public function unpayment()
    {
        return $this->andWhere(['payment' => 'no']);
    }
}