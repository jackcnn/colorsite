<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishspec}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property string $name
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class Dishspec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishspec}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['token'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ownerid' => 'Ownerid',
            'token' => 'Token',
            'name' => 'Name',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishspecQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishspecQuery(get_called_class());
    }
}
