<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishcart}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property integer $store_id
 * @property string $openid
 * @property string $name
 * @property string $list
 * @property string $sn
 * @property string $mark
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $tid
 * @property integer $isdone
 */
class Dishcart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishcart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'store_id', 'type', 'created_at', 'updated_at', 'tid', 'isdone'], 'integer'],
            [['list', 'mark'], 'string'],
            [['openid', 'sn'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 150],
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
            'store_id' => 'Store ID',
            'openid' => 'Openid',
            'name' => '昵称',
            'list' => 'List',
            'sn' => 'Sn',
            'mark' => 'Mark',
            'type' => '0为点餐，1为加菜',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tid' => '桌子编号',
            'isdone' => '是否已结束',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishcartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishcartQuery(get_called_class());
    }
}
