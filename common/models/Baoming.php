<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%baoming}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $tel
 * @property string $func
 * @property string $ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class Baoming extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%baoming}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'tel', 'func', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'tel' => 'Tel',
            'func' => 'Func',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\BaomingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BaomingQuery(get_called_class());
    }
}
