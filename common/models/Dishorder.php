<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishorder}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $title
 * @property integer $store_id
 * @property string $ordersn
 * @property string $sn
 * @property integer $status
 * @property integer $amount
 * @property integer $paytime
 * @property string $list
 * @property string $payinfo
 * @property string $openid
 * @property string $formid
 * @property string $openid_list
 * @property string $payopenid
 * @property string $paywxname
 * @property string $paytype
 * @property integer $table_num
 * @property string $transaction_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $unifiedorder_res
 * @property integer $isdone
 * @property integer $coupon_fee
 */
class Dishorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishorder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'store_id', 'status', 'amount', 'paytime', 'table_num', 'created_at', 'updated_at', 'isdone', 'coupon_fee'], 'integer'],
            [['list', 'payinfo', 'openid_list', 'unifiedorder_res'], 'string'],
            [['title', 'openid', 'formid', 'payopenid'], 'string', 'max' => 100],
            [['ordersn', 'sn', 'paytype'], 'string', 'max' => 30],
            [['paywxname'], 'string', 'max' => 255],
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
            'title' => '商品',
            'store_id' => 'Store ID',
            'ordersn' => '订单编号',
            'sn' => 'Sn',
            'status' => '订单状态，0确认下单，1可付款，2已付款',
            'amount' => '订单总额',
            'paytime' => 'Paytime',
            'list' => 'List',
            'payinfo' => 'Payinfo',
            'openid' => '店员openid',
            'formid' => '小程序提交的formid',
            'openid_list' => '客户openid',
            'payopenid' => '付款openid',
            'paywxname' => '付款名称',
            'paytype' => 'Paytype',
            'table_num' => '桌号',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'unifiedorder_res' => '微信统一下单接口返回结果',
            'isdone' => '1',
            'coupon_fee' => '代金券金额',
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

    public function getStore()
    {
        return $this->hasOne(Stores::className(),['id'=>'store_id']);
    }
    public function getPayname()
    {
        return $this->hasOne(Member::className(),['openid'=>'payopenid']);
    }
    public function getTabletitle()
    {
        return $this->hasOne(Dishtable::className(),['id'=>'table_num']);
    }
}
