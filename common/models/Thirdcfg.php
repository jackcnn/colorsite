<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%thirdcfg}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property string $type
 * @property string $appid
 * @property string $appsecret
 * @property string $mch_number
 * @property string $mch_key
 * @property string $apiclient_cert
 * @property string $apiclient_key
 * @property string $api_token
 * @property string $aeskey
 * @property integer $isuse
 * @property integer $created_at
 * @property integer $updated_at
 */
class Thirdcfg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thirdcfg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'isuse', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'required'],
            [['token', 'type', 'appid', 'mch_number'], 'string', 'max' => 100],
            [['appsecret', 'mch_key', 'apiclient_cert', 'apiclient_key', 'api_token', 'aeskey'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ownerid' => '所属user表一级id',
            'token' => 'user表token',
            'type' => '配置所属，weixin,alipay等',
            'appid' => 'Appid',
            'appsecret' => 'Appsecret',
            'mch_number' => 'Mch Number',
            'mch_key' => 'Mch Key',
            'apiclient_cert' => 'Apiclient Cert',
            'apiclient_key' => 'Apiclient Key',
            'api_token' => 'Api Token',
            'aeskey' => 'Aeskey',
            'isuse' => '是否启用1是，0否',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ThirdcfgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ThirdcfgQuery(get_called_class());
    }
}
