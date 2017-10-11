<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Clerk;

/**
 * ClerkSearch represents the model behind the search form about `common\models\Clerk`.
 */
class ClerkSearch extends Clerk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownerid', 'store_id', 'created_at', 'updated_at'], 'integer'],
            [['token', 'name', 'desc', 'phone', 'rights', 'openid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Clerk::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ownerid' => $this->ownerid,
            'store_id' => $this->store_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'rights', $this->rights])
            ->andFilterWhere(['like', 'openid', $this->openid]);

        return $dataProvider;
    }
}
