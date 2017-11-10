<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Dishcart]].
 *
 * @see Dishcart
 */
class DishcartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Dishcart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Dishcart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
