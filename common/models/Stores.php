<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%stores}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property string $name
 * @property string $desc
 * @property string $logo
 * @property string $address
 * @property string $lng
 * @property string $lat
 * @property string $phone
 * @property integer $needpay
 * @property integer $created_at
 * @property integer $updated_at
 */
class Stores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stores}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'needpay', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 500],
            [['logo'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 255],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 40],
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
            'name' => '名称',
            'desc' => '简介',
            'logo' => '封面图',
            'address' => '地址',
            'lng' => '经度',
            'lat' => '纬度',
            'phone' => '联系电话',
            'needpay' => '付款打单',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return StoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StoresQuery(get_called_class());
    }
}
