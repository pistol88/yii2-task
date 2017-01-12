<?php

namespace pistol88\task\models;

use Yii;

/**
 * This is the model class for table "task_fine".
 *
 * @property integer $id
 * @property integer $fine
 * @property integer $user_id
 * @property string $reason
 * @property integer $date
 */
class Fine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_fine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fine', 'user_id', 'reason', 'date'], 'required'],
            [['fine', 'user_id', 'date'], 'integer'],
            [['reason'], 'string', 'max' => 55],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fine' => 'Штраф',
            'user_id' => 'Пользователь',
            'reason' => 'Причина',
            'date' => 'Дата',
        ];
    }
}
