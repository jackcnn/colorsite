<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cs_dishorderopenid".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property integer $store_id
 * @property string $openid
 * @property integer $orderid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Dishorderopenid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cs_dishorderopenid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'ownerid', 'store_id', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['openid'], 'string', 'max' => 100],
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
            'orderid' => 'Orderid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishorderopenidQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishorderopenidQuery(get_called_class());
    }
}
