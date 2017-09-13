<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Holiday;

/**
 * HollydaySearcha represents the model behind the search form about `frontend\app\models\Hollyday`.
 */
class HolidaySearch extends Holiday
{   
	public $fromdate;
	public $todate;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
           
            [['date', 'description', 'createdby', 'createddate', 'modifiedby', 'modifieddate','fromdate','todate'], 'safe'],
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
		
        $query = Holiday::find()->Where(['deleted' =>0]);
                           
                             
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
            'pageSize' => 5,
        ],
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
            'date' => $this->date,
            'createddate' => $this->createddate,
            'modifieddate' => $this->modifieddate,
        ]);
           
        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'createdby', $this->createdby])
            ->andFilterWhere(['like', 'modifiedby', $this->modifiedby])
           ->andFilterWhere(['between', 'date', $this->fromdate, $this->todate]);
            
              return $dataProvider;
    }
}
