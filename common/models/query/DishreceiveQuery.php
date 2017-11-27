<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Dishreceive]].
 *
 * @see \common\models\Dishreceive
 */
class DishreceiveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Dishreceive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Dishreceive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
