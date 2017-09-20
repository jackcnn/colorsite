<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%oauth2}}".
 *
 * @property integer $id
 * @property integer $owid
 * @property integer $memberid
 * @property integer $userid
 * @property string $type
 * @property string $openid
 * @property string $name
 * @property string $avatar
 * @property integer $sex
 * @property string $province
 * @property string $city
 * @property string $country
 * @property string $privilege
 * @property integer $subscribe
 * @property string $encrypt
 * @property string $unionid
 * @property string $access_token
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 */
class Oauth2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth2}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owid', 'openid'], 'required'],
            [['owid', 'memberid', 'userid', 'sex', 'subscribe', 'created_at', 'updated_at'], 'integer'],
            [['privilege'], 'string'],
            [['type'], 'string', 'max' => 10],
            [['openid', 'name', 'province', 'city', 'country', 'encrypt', 'unionid'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 255],
            [['access_token', 'auth_key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owid' => 'owid标识',
            'memberid' => '对应member表的id',
            'userid' => '对应user表的id',
            'type' => 'oauth2 类型',
            'openid' => '用户的唯一标识',
            'name' => '用户昵称',
            'avatar' => '用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。',
            'sex' => '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
            'province' => '用户个人资料填写的省份',
            'city' => '普通用户个人资料填写的城市',
            'country' => '国家，如中国为CN',
            'privilege' => '用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）',
            'subscribe' => '是否关注',
            'encrypt' => '加密字符串',
            'unionid' => '只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\Oauth2Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\Oauth2Query(get_called_class());
    }
}
