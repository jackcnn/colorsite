<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dishes;

/**
 * DishesSearch represents the model behind the search form about `common\models\Dishes`.
 */
class DishesSearch extends Dishes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownerid', 'cateid', 'price', 'stock', 'multi', 'recommend', 'onsale', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['token', 'name', 'desc', 'spec', 'cover', 'unit', 'labes'], 'safe'],
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
        $query = Dishes::find();

        // add conditions that should always apply here

        $query->joinWith(['category']);


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
            '{{%dishes}}.ownerid' => $this->ownerid,
            'cateid' => $this->cateid,
            'price' => $this->price,
            'stock' => $this->stock,
            'multi' => $this->multi,
            'recommend' => $this->recommend,
            'onsale' => $this->onsale,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', '{{%dishes}}.name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'spec', $this->spec])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'labes', $this->labes]);

        return $dataProvider;
    }
}
