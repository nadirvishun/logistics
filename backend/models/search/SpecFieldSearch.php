<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SpecField;

/**
 * SpecFieldSearch represents the model behind the search form about `backend\models\SpecField`.
 */
class SpecFieldSearch extends SpecField
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'by_number', 'status', 'sort', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['field_name', 'name'], 'safe'],
            [['min', 'max'], 'number'],
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
        $query = SpecField::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => ['sort' => SORT_DESC]],
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
            'min' => $this->min,
            'max' => $this->max,
            'by_number' => $this->by_number,
            'status' => $this->status,
            'sort' => $this->sort,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'field_name', $this->field_name])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
