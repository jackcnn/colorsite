<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%taobaolist}}".
 *
 * @property integer $id
 * @property string $item_id
 * @property string $title
 * @property string $main_pic
 * @property string $item_url
 * @property string $category
 * @property string $click_url
 * @property string $price
 * @property string $sale
 * @property string $bilv
 * @property string $yongjin
 * @property string $wangwang
 * @property string $seller_id
 * @property string $shop_name
 * @property string $taobao
 * @property string $coupon_id
 * @property string $coupon_total
 * @property string $coupon_remain
 * @property string $coupon_title
 * @property string $startime
 * @property string $endtime
 * @property string $coupon_url
 * @property string $coupon_surl
 */
class Taobaolist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%taobaolist}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'title', 'main_pic', 'item_url', 'category', 'click_url', 'price', 'sale', 'bilv', 'yongjin', 'wangwang', 'seller_id', 'shop_name', 'taobao', 'coupon_id', 'coupon_total', 'coupon_remain', 'coupon_title', 'startime', 'endtime', 'coupon_url', 'coupon_surl'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'title' => 'Title',
            'main_pic' => 'Main Pic',
            'item_url' => 'Item Url',
            'category' => 'Category',
            'click_url' => 'Click Url',
            'price' => 'Price',
            'sale' => 'Sale',
            'bilv' => 'Bilv',
            'yongjin' => 'Yongjin',
            'wangwang' => 'Wangwang',
            'seller_id' => 'Seller ID',
            'shop_name' => 'Shop Name',
            'taobao' => 'Taobao',
            'coupon_id' => 'Coupon ID',
            'coupon_total' => 'Coupon Total',
            'coupon_remain' => 'Coupon Remain',
            'coupon_title' => 'Coupon Title',
            'startime' => 'Startime',
            'endtime' => 'Endtime',
            'coupon_url' => 'Coupon Url',
            'coupon_surl' => 'Coupon Surl',
        ];
    }

    /**
     * @inheritdoc
     * @return TaobaolistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaobaolistQuery(get_called_class());
    }
}
