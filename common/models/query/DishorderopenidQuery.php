<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Dishorderopenid]].
 *
 * @see \common\models\Dishorderopenid
 */
class DishorderopenidQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Dishorderopenid[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Dishorderopenid|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
