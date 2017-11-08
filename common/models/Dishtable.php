<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishtable}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $title
 * @property integer $store_id
 * @property string $path
 * @property string $code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Dishtable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishtable}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'store_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['path', 'code'], 'string', 'max' => 255],
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
            'title' => '标题',
            'store_id' => '所述门店',
            'path' => '地址',
            'code' => '图片位置',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishtableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishtableQuery(get_called_class());
    }
}
