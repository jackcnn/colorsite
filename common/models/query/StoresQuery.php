<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Stores]].
 *
 * @see \common\models\Stores
 */
class StoresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Stores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Stores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
