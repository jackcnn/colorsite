<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Taobaolist]].
 *
 * @see Taobaolist
 */
class TaobaolistQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Taobaolist[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Taobaolist|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
