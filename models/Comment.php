<?php

namespace pistol88\task\models;

use Yii;

/**
 * This is the model class for table "task_comment".
 *
 * @property integer $id
 * @property integer $node_id
 * @property integer $user_id
 * @property integer $parent
 * @property string $text
 * @property integer $timestamp
 * @property string $for_users
 * @property string $username
 * @property integer $rework_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_id', 'user_id', 'parent', 'text', 'timestamp', 'for_users', 'username', 'rework_id'], 'required'],
            [['node_id', 'user_id', 'parent', 'timestamp', 'rework_id'], 'integer'],
            [['text', 'for_users'], 'string'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'node_id' => 'Node ID',
            'user_id' => 'User ID',
            'parent' => 'Parent',
            'text' => 'Text',
            'timestamp' => 'Timestamp',
            'for_users' => 'For Users',
            'username' => 'Username',
            'rework_id' => 'Rework ID',
        ];
    }
}
