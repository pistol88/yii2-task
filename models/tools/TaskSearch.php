<?php

namespace pistol88\task\models\tools;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\task\models\Task;

/**
 * TaskSearch represents the model behind the search form of `pistol88\task\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'price', 'haron_user_id', 'updated'], 'integer'],
            [['name', 'description', 'date_start', 'date_deadline', 'accesses', 'payment', 'members_data', 'members', 'status'], 'safe'],
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
    public function search($query, $params)
    {
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
            'status' => $this->status,
            'project_id' => $this->project_id,
            'date_start' => $this->date_start,
            'date_deadline' => $this->date_deadline,
            'price' => $this->price,
            'haron_user_id' => $this->haron_user_id,
            'updated' => $this->updated,
            'payment' => $this->payment,
        ]);
        
        if(isset($params['status'])) {
            $query->andFilterWhere([
                'status' => $params['status'],
            ]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'accesses', $this->accesses]);

        return $dataProvider;
    }
}
