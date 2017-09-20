<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Oauth2]].
 *
 * @see \common\models\Oauth2
 */
class Oauth2Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Oauth2[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Oauth2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
