<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property integer $pid
 * @property string $name
 * @property string $logo
 * @property string $slogo
 * @property string $desc
 * @property string $table
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'token'], 'required'],
            [['ownerid', 'pid', 'created_at', 'updated_at', 'sort'], 'integer'],
            [['desc'], 'string'],
            [['token', 'table'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['logo', 'slogo'], 'string', 'max' => 255],
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
            'pid' => 'Pid',
            'name' => '分类名称',
            'logo' => '分类图标',
            'slogo' => '分类图标2',
            'desc' => '描述',
            'table' => '所属表名',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort' => '排序',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CategoryQuery(get_called_class());
    }
}
