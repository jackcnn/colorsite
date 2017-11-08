<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dishorder;

/**
 * DishorderSearch represents the model behind the search form about `common\models\Dishorder`.
 */
class DishorderSearch extends Dishorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownerid', 'store_id', 'status', 'amount', 'paytime', 'table_num', 'created_at', 'updated_at'], 'integer'],
            [['ordersn', 'sn', 'list', 'payinfo', 'openid', 'openid_list', 'payopenid', 'paytype', 'transaction_id'], 'safe'],
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
        $query = Dishorder::find();

        $query->orderBy("created_at DESC");

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
            'status' => $this->status,
            'amount' => $this->amount,
            'paytime' => $this->paytime,
            'table_num' => $this->table_num,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ordersn', $this->ordersn])
            ->andFilterWhere(['like', 'sn', $this->sn])
            ->andFilterWhere(['like', 'list', $this->list])
            ->andFilterWhere(['like', 'payinfo', $this->payinfo])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'openid_list', $this->openid_list])
            ->andFilterWhere(['like', 'payopenid', $this->payopenid])
            ->andFilterWhere(['like', 'paytype', $this->paytype])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
