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
 * @property string $sn
 * @property integer $status
 * @property integer $amount
 * @property integer $paytime
 * @property string $list
 * @property string $payinfo
 * @property string $openid
 * @property string $openid_list
 * @property string $payopenid
 * @property string $paytype
 * @property integer $table_num
 * @property string $transaction_id
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
            [['ownerid', 'store_id', 'status', 'amount', 'paytime', 'table_num', 'created_at', 'updated_at'], 'integer'],
            [['list', 'payinfo', 'openid_list'], 'string'],
            [['ordersn', 'sn', 'paytype'], 'string', 'max' => 30],
            [['openid', 'payopenid'], 'string', 'max' => 100],
            [['transaction_id'], 'string', 'max' => 50],
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
            'sn' => 'Sn',
            'status' => '订单状态，0确认下单，1可付款，2已付款',
            'amount' => '订单总额',
            'paytime' => 'Paytime',
            'list' => 'List',
            'payinfo' => 'Payinfo',
            'openid' => '店员openid',
            'openid_list' => '客户openid',
            'payopenid' => '付款openid',
            'paytype' => 'Paytype',
            'table_num' => '桌号',
            'transaction_id' => 'Transaction ID',
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
