<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%payconfig}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $title
 * @property string $mch_number
 * @property string $mch_key
 * @property string $type
 * @property string $cert_path
 * @property string $key_path
 * @property integer $created_at
 * @property integer $isuse
 * @property integer $updated_at
 */
class Payconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payconfig}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'created_at', 'isuse', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['mch_number', 'type'], 'string', 'max' => 50],
            [['mch_key', 'cert_path', 'key_path'], 'string', 'max' => 255],
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
            'title' => '标题',
            'mch_number' => '商户号',
            'mch_key' => '商户KEY值',
            'type' => '类型',
            'cert_path' => 'cert证书',
            'key_path' => 'key证书',
            'created_at' => 'Created At',
            'isuse' => '是否启用',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return PayconfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayconfigQuery(get_called_class());
    }
}
