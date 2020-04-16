<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OtrosIngresos;

/**
 * OtrosIngresosSearch represents the model behind the search form of `frontend\models\OtrosIngresos`.
 */
class OtrosIngresosSearch extends OtrosIngresos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vehiculo_id', 'tipo_ingreso_id', 'cliente_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['vehiculo_id','tipo_ingreso_id','fecha', 'observacion', 'creado_el', 'actualizado_el'], 'safe'],
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

    /**
     * Búsqueda otros ingresos por vehiculo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOtrosIngresosVehiculo($params){

        $query = OtrosIngresos::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'vehiculo_id' => $this->vehiculo_id,
        ]);

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
        $query = OtrosIngresos::find();

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
            'fecha' => $this->fecha,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_ingreso_id' => $this->tipo_ingreso_id,
            'cliente_id' => $this->cliente_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);
        
        if (!empty($this->fecha)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha', $date1, $date2]);
        }


        return $dataProvider;
    }
}
