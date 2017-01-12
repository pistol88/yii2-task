<?php

namespace pistol88\task\models\tools;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\task\models\Rework;

/**
 * ReworkSearch represents the model behind the search form of `pistol88\task\models\Rework`.
 */
class ReworkSearch extends Rework
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'perfomer_id', 'number'], 'integer'],
            [['text', 'date_start', 'date_deadline', 'status', 'payment', 'payment_perfomer', 'comment'], 'safe'],
            [['price'], 'number'],
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
        $query = Rework::find();

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
            'date_start' => $this->date_start,
            'date_deadline' => $this->date_deadline,
            'task_id' => $this->task_id,
            'perfomer_id' => $this->perfomer_id,
            'price' => $this->price,
            'number' => $this->number,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'payment', $this->payment])
            ->andFilterWhere(['like', 'payment_perfomer', $this->payment_perfomer])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
