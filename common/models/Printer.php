<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cs_printer".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $title
 * @property string $machine_code
 * @property string $actions
 * @property integer $isuse
 * @property integer $store_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Printer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cs_printer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'isuse', 'store_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'machine_code'], 'string', 'max' => 100],
            [['actions'], 'string', 'max' => 255],
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
            'title' => '打印机名称',
            'machine_code' => '打印机终端号',
            'actions' => '打印机操作',
            'isuse' => '是否启用',
            'store_id' => '门店id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PrinterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PrinterQuery(get_called_class());
    }

    public function getStore()
    {
        return $this->hasOne(Stores::className(),['id'=>'store_id']);
    }
}
