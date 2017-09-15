<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property integer $id
 * @property string $token
 * @property string $name
 * @property string $desc
 * @property string $path
 * @property string $table
 * @property integer $markid
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['markid', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['token', 'name', 'table'], 'string', 'max' => 50],
            [['desc', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'name' => '名称',
            'desc' => '描述',
            'path' => '链接',
            'table' => '关联表名',
            'markid' => '关联表名的ID',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ImagesQuery(get_called_class());
    }
}
