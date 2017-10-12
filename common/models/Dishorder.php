<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cs_dishorder".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property integer $store_id
 * @property string $ordersn
 * @property integer $status
 * @property integer $amount
 * @property integer $paytime
 * @property string $list
 * @property string $openid
 * @property string $paytype
 * @property integer $created_at
 * @property integer $updated_at
 */
class Dishorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cs_dishorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'store_id', 'status', 'amount', 'paytime', 'created_at', 'updated_at'], 'integer'],
            [['list'], 'string'],
            [['ordersn', 'paytype'], 'string', 'max' => 30],
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
            'ordersn' => '订单编号',
            'status' => '订单状态，0点单，1确认下单，2可付款，3已付款',
            'amount' => 'Amount',
            'paytime' => 'Paytime',
            'list' => 'List',
            'openid' => 'Openid',
            'paytype' => 'Paytype',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishorderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishorderQuery(get_called_class());
    }
}
