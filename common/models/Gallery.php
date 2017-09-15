<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property string $title
 * @property string $time
 * @property string $source
 * @property string $author
 * @property integer $cateid
 * @property integer $sort
 * @property string $logo
 * @property string $content
 * @property integer $isopen
 * @property integer $created_at
 * @property integer $updated_at
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'cateid', 'sort', 'isopen', 'created_at', 'updated_at'], 'integer'],
            [['token', 'cateid'], 'required'],
            [['content'], 'string'],
            [['token'], 'string', 'max' => 50],
            [['title', 'time', 'source', 'author'], 'string', 'max' => 100],
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
            'ownerid' => 'Ownerid',
            'token' => 'Token',
            'title' => '标题',
            'time' => 'Time',
            'source' => 'Source',
            'author' => 'Author',
            'cateid' => '分类id',
            'sort' => '排序',
            'logo' => '封面图',
            'content' => '内容',
            'isopen' => '是否显示',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GalleryQuery(get_called_class());
    }
}
