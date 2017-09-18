<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $token
 * @property integer $is_admin
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property string $avatar
 * @property string $auth_key
 * @property string $access_token
 * @property integer $is_active
 * @property integer $expire
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_admin', 'is_active', 'expire', 'created_at', 'updated_at'], 'integer'],
            //[['token', 'username', 'password'], 'required'],
            [['token', 'username', 'password', 'nickname', 'avatar', 'auth_key', 'access_token'], 'string', 'max' => 100],
            [['token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '父ID',
            'token' => '用户标识',
            'is_admin' => 'ADMIN后台用户',
            'username' => '用户名',
            'password' => '密码',
            'nickname' => '昵称',
            'avatar' => '头像',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'is_active' => '是否可用',
            'expire' => '过期时间',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }
}
