<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%behavior_log}}".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $ip
 * @property string $behavior
 * @property string $info
 * @property integer $created_at
 * @property integer $updated_at
 */
class BehaviorLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%behavior_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at', 'updated_at'], 'integer'],
            [['info'], 'string'],
            [['ip'], 'string', 'max' => 50],
            [['behavior'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户ID',
            'ip' => 'Ip',
            'behavior' => '标记操作行为',
            'info' => 'Info',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\BehaviorLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BehaviorLogQuery(get_called_class());
    }
}
