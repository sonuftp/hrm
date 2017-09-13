<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Leave;


/**
 * LeaveSearch represents the model behind the search form about `frontend\models\leave`.
 */
class LeaveSearch extends leave
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['user_id', 'from_date', 'to_date', 'remark', 'status', 'created_id', 'modify_id', 'created_date', 'modify_date'], 'safe'],
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
       
        if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){
        $query = leave::find()->andWhere(['status'=>1]);
        } else {
            // print_r(Yii::$app->user->getId());
            // exit;

           $query = leave::find()->andWhere(['user_id'=>Yii::$app->User->getId()]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'type' => $this->type,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_id', $this->created_id])
            ->andFilterWhere(['like', 'modify_id', $this->modify_id])
            ->andFilterWhere(['between', 'created_at', $this->from_date, $this->to_date]);

        return $dataProvider;
    }
    public function searchleave($params)
    {
       
        if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){
        $query = leave::find()->andWhere(['NOT IN','status',[1]]);
        } else {
            // print_r(Yii::$app->user->getId());
            // exit;

           $query = leave::find()->andWhere(['user_id'=>Yii::$app->User->getId()]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'type' => $this->type,
            'created_date' => $this->created_date,
            'modify_date' => $this->modify_date,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_id', $this->created_id])
            ->andFilterWhere(['like', 'modify_id', $this->modify_id])
            ->andFilterWhere(['between', 'created_at', $this->from_date, $this->to_date]);

        return $dataProvider;
    }
}
