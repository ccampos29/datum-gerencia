<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Mediciones;

/**
 * MedicionesSearch represents the model behind the search form of `frontend\models\Mediciones`.
 */
class MedicionesSearch extends Mediciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado_vehiculo', 'proviene_de', 'vehiculo_id', 'usuario_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['fecha_medicion', 'hora_medicion', 'observacion', 'creado_el', 'actualizado_el','tipo_medicion'], 'safe'],
            [['valor_medicion'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function searchFlotaMediciones($params){
        $query = Mediciones::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'vehiculo_id' => $this->vehiculo_id,
            'valor_medicion'=>$this->valor_medicion
        ]);

        $query->andFilterWhere(['between', 'fecha_medicion', $this->fecha_1, $this->fecha_2]);

        return $dataProvider;
    }

    /**
     * Implementación DataProvider
     * @return ActiveDataProvider
     */
    public function callingDataProvider($query,$params){
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
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
        $query = Mediciones::find()->orderBy(['id'=> SORT_DESC]);

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
            'fecha_medicion' => $this->fecha_medicion,
            'hora_medicion' => $this->hora_medicion,
            'valor_medicion' => $this->valor_medicion,
            'estado_vehiculo' => $this->estado_vehiculo,
            'proviene_de' => $this->proviene_de,
            'vehiculo_id' => $this->vehiculo_id,
            'usuario_id' => $this->usuario_id,
            'tipo_medicion' => $this->tipo_medicion,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'valor_medicion', $this->valor_medicion]);
            
        if (!empty($this->fecha_medicion)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha_medicion);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_medicion', $date1, $date2]);
        }
        if (!empty($this->hora_medicion)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->hora_medicion);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'hora_medicion', $date1, $date2]);
        }
        return $dataProvider;
    }
}
