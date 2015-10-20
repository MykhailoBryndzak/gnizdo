<?php

namespace frontend\modules\costs\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\costs\models\CostsUsers;


/**
 * CostsUsersSearch represents the model behind the search form about `frontend\modules\costs\models\CostsUsers`.
 */
class CostsUsersSearch extends CostsUsers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'user_id', 'cost'], 'integer'],
            [['description', 'date'], 'safe'],
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
        $id = Yii::$app->user->identity->getId();
        $query = CostsUsers::find()
                ->where(['user_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'cost' => $this->cost,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public static function convertDate($inputDate)
    {
        $date = new \DateTime($inputDate);
        return $date->format('Y-m-d');
    }
}