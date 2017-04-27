<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PreOrder;

/**
 * PreOrderSearch represents the model behind the search form about `backend\models\PreOrder`.
 */
class PreOrderSearch extends PreOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_sn', 'region_id', 'goods_number', 'is_view', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['region_name', 'contact', 'mobile', 'address', 'goods_name', 'spec_field', 'spec_field_name', 'remark'], 'safe'],
            [['goods_weight', 'goods_volume', 'estimate_price'], 'number'],
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
        $query = PreOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => ['is_view' => SORT_ASC, 'order_id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'order_sn' => $this->order_sn,
            'region_id' => $this->region_id,
            'goods_weight' => $this->goods_weight,
            'goods_volume' => $this->goods_volume,
            'goods_number' => $this->goods_number,
            'estimate_price' => $this->estimate_price,
            'is_view' => $this->is_view,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'region_name', $this->region_name])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'spec_field', $this->spec_field])
            ->andFilterWhere(['like', 'spec_field_name', $this->spec_field_name])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
