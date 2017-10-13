<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $name
 * @property string $phone
 * @property string $openid
 * @property string $wxname
 * @property string $wxpic
 * @property string $wxinfo
 * @property string $password
 * @property string $access_token
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'created_at', 'updated_at'], 'integer'],
            [['wxinfo'], 'string'],
            [['name', 'openid', 'password', 'access_token', 'auth_key'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 30],
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
            'name' => 'Name',
            'phone' => 'Phone',
            'openid' => 'Openid',
            'wxname' => 'Wxname',
            'wxpic' => 'Wxpic',
            'wxinfo' => 'Wxinfo',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\MemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MemberQuery(get_called_class());
    }
}
