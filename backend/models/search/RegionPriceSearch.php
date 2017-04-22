<?php

namespace backend\models\search;

use backend\models\SpecField;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\RegionPrice;

/**
 * RegionPriceSearch represents the model behind the search form about `backend\models\RegionPrice`.
 */
class RegionPriceSearch extends RegionPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'transport_type', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['region_name'], 'safe'],
            [['depart_limitation', 'transport_limitation', 'pickup_limitation'], 'number'],
            [array_keys(SpecField::getFieldNameOptions()), 'number']//增加动态规格验证
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
        $query = RegionPrice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => ['sort' => SORT_DESC, 'id' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //设置只取非顶级的
        $query->andFilterWhere(['!=', 'pid', 0]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'pid' => $this->pid,
            'transport_type' => $this->transport_type,
            'depart_limitation' => $this->depart_limitation,
            'transport_limitation' => $this->transport_limitation,
            'pickup_limitation' => $this->pickup_limitation,
            'status' => $this->status,
            'sort' => $this->sort,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);
        //增加动态的检索
        $dynamic = SpecField::getFieldNameOptions();
        $add = array_keys($dynamic);
        if (!empty($add)) {
            $condition = [];
            foreach ($add as $value) {
                $condition[$value] = $this->$value;
            }
            $query->andFilterWhere($condition);
        }

        $query->andFilterWhere(['like', 'region_name', $this->region_name]);

        return $dataProvider;
    }
}
