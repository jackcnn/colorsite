<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishreceive}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $name
 * @property string $phone
 * @property string $wxname
 * @property string $wxpic
 * @property string $openid
 * @property integer $is_receive
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $store_id
 */
class Dishreceive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishreceive}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'is_receive', 'created_at', 'updated_at', 'store_id'], 'integer'],
            [['name', 'phone', 'openid'], 'string', 'max' => 100],
            [['wxname', 'wxpic'], 'string', 'max' => 255],
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
            'name' => '名称',
            'phone' => '手机',
            'wxname' => '微信昵称',
            'wxpic' => '微信头像',
            'openid' => 'Openid',
            'is_receive' => '接收消息',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'store_id' => '门店id',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishreceiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishreceiveQuery(get_called_class());
    }
}
