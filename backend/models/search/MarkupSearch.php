<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Markup;

/**
 * MarkupSearch represents the model behind the search form about `backend\models\Markup`.
 */
class MarkupSearch extends Markup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'markup_ratio', 'type', 'sort', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = Markup::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => [
                //'pageSize' => 20,
            //],
            //'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'markup_ratio' => $this->markup_ratio,
            'type' => $this->type,
            'sort' => $this->sort,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
