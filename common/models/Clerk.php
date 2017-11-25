<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%clerk}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property integer $store_id
 * @property string $name
 * @property string $desc
 * @property string $phone
 * @property string $rights
 * @property string $openid
 * @property string $wxname
 * @property string $avatar
 * @property string $password
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $public_openid
 * @property integer $receive
 */
class Clerk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clerk}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'store_id', 'created_at', 'updated_at', 'receive'], 'integer'],
            [['token'], 'string', 'max' => 50],
            [['name', 'openid', 'public_openid'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            [['rights'], 'string', 'max' => 500],
            [['wxname'], 'string', 'max' => 200],
            [['avatar', 'password'], 'string', 'max' => 150],
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
            'store_id' => '门店id',
            'name' => '名称',
            'desc' => '描述',
            'phone' => '手机',
            'rights' => '权限',
            'openid' => '小程序openid',
            'wxname' => '微信名称',
            'avatar' => '头像',
            'password' => '操作密码',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'public_openid' => '公众号openid,接收模版消息用的',
            'receive' => '是否接收消息',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ClerkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ClerkQuery(get_called_class());
    }
}
