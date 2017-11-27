<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dishreceive;

/**
 * DishreceiveSearch represents the model behind the search form about `\common\models\Dishreceive`.
 */
class DishreceiveSearch extends Dishreceive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownerid', 'store_id', 'is_receive', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'wxname', 'wxpic', 'openid'], 'safe'],
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
        $query = Dishreceive::find();

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
            'is_receive' => $this->is_receive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'store_id' => $this->store_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'wxname', $this->wxname])
            ->andFilterWhere(['like', 'wxpic', $this->wxpic])
            ->andFilterWhere(['like', 'openid', $this->openid]);

        return $dataProvider;
    }
}
