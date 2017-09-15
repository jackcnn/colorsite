<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property string $name
 * @property string $logo
 * @property string $keywords
 * @property string $description
 * @property string $smtp
 * @property integer $created_at
 * @property integer $updated_at
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'required'],
            [['keywords', 'description', 'smtp'], 'string'],
            [['token', 'name'], 'string', 'max' => 100],
            [['logo'], 'string', 'max' => 255],
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
            'token' => '所属user表token',
            'name' => 'site名称',
            'logo' => 'site logo',
            'keywords' => '网站关键词',
            'description' => '网站描述',
            'smtp' => 'SMTP邮箱配置',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\SiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SiteQuery(get_called_class());
    }
}
