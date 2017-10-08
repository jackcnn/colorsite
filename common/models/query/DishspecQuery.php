<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Dishspec]].
 *
 * @see \common\models\Dishspec
 */
class DishspecQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Dishspec[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Dishspec|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
