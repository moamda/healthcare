<?php

namespace app\modules\patient\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\patient\models\Appointments;

/**
 * AppointmentsSearch represents the model behind the search form about `app\modules\patient\models\Appointments`.
 */
class AppointmentsSearch extends Appointments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'patient_id', 'specialist_id'], 'integer'],
            [['reference_no', 'appointment_date', 'status', 'reason', 'notes', 'created_at', 'updated_at'], 'safe'],
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
        $query = Appointments::find();

        $userId = Yii::$app->user->id;

        // var_dump($userId); die;
        
        $query->orderBy(['appointment_date' => SORT_ASC]);

        $query->andWhere([
            'or',
            ['patient_id' => $userId], 
            ['specialist_id' => $userId]   
        ]);

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
            'patient_id' => $this->patient_id,
            'specialist_id' => $this->specialist_id,
        ]);

        $query->andFilterWhere(['like', 'appointment_date', $this->appointment_date])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'reference_no', $this->reference_no])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
