<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dishes}}".
 *
 * @property integer $id
 * @property integer $ownerid
 * @property string $token
 * @property integer $cateid
 * @property string $name
 * @property string $desc
 * @property integer $price
 * @property integer $oprice
 * @property integer $stock
 * @property integer $multi
 * @property string $spec
 * @property integer $recommend
 * @property integer $onsale
 * @property string $cover
 * @property integer $sort
 * @property string $unit
 * @property string $labes
 * @property integer $month_sales
 * @property integer $created_at
 * @property integer $updated_at
 */
class Dishes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerid', 'cateid', 'price', 'oprice', 'stock', 'multi', 'recommend', 'onsale', 'sort', 'month_sales', 'created_at', 'updated_at'], 'integer'],
            [['spec'], 'string'],
            [['token'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 500],
            [['cover'], 'string', 'max' => 150],
            [['unit'], 'string', 'max' => 20],
            [['labes'], 'string', 'max' => 255],
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
            'cateid' => '分类',
            'name' => '名称',
            'desc' => '描述',
            'price' => '价格，以分为单位',
            'oprice' => '原价',
            'stock' => '每日库存',
            'multi' => '是否多规格',
            'spec' => '多规格数据',
            'recommend' => '是否推荐',
            'onsale' => '是否在售',
            'cover' => '封面图',
            'sort' => '排序',
            'unit' => '计量单位',
            'labes' => '标签',
            'month_sales' => '月销量',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DishesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DishesQuery(get_called_class());
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(),['id'=>'cateid']);
    }
}
