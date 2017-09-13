<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Workdays;

/**
 * WorkdaysSearch represents the model behind the search form about `frontend\app\models\Workdays`.
 */
class WorkdaysSearch extends Workdays
{
	public $frommonth;
	public $tomonth;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['sun','month','year', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'createdby', 'createddate', 'modifiedby', 'modifiedate','frommonth','tomonth'], 'safe'],
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
        $query = Workdays::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
            'pageSize' => 5,
            
        ],
        'sort'=> ['defaultOrder' => ['createddate'=>SORT_DESC]]
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
            'month' => $this->month,
            'year' => $this->year,
            'createddate' => $this->createddate,
            'modifieddate' => $this->modifieddate,
        ]);

        $query->andFilterWhere(['like', 'sun', $this->sun])
         //   ->andFilterWhere(['like', 'mon', $this->mon])
           // ->andFilterWhere(['like', 'tue', $this->tues])
            //->andFilterWhere(['like', 'wed', $this->wed])
            //->andFilterWhere(['like', 'thu', $this->thu])
            //->andFilterWhere(['like', 'fri', $this->fri])
             ->andFilterWhere(['like', 'month', $this->month])
             ->andFilterWhere(['like', 'year', $this->year]);
            //->andFilterWhere(['like', 'sat', $this->sat]);
           
        return $dataProvider;
    }
}
