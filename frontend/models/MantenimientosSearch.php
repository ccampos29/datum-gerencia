<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Mantenimientos;

/**
 * MantenimientosSearch represents the model behind the search form of `frontend\models\Mantenimientos`.
 */
class MantenimientosSearch extends Mantenimientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'medicion', 'vehiculo_id', 'trabajo_id', 'tipo_mantenimiento_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['vehiculo_id','descripcion', 'fecha_hora_ejecucion', 'estado', 'duracion', 'creado_el', 'actualizado_el'], 'safe'],
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
     * Búsqueda mantenimientos por vehiculo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchMantenimientoVehiculos($params){

        $query = Mantenimientos::find();

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
        $query = Mantenimientos::find();

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
            'fecha_hora_ejecucion' => $this->fecha_hora_ejecucion,
            'medicion' => $this->medicion,
            'estado' => $this->estado,
            'vehiculo_id' => $this->vehiculo_id,
            'trabajo_id' => $this->trabajo_id,
            'tipo_mantenimiento_id' => $this->tipo_mantenimiento_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'duracion', $this->duracion]);

        if (!empty($this->fecha_hora_ejecucion)) { //you dont need the if function if yourse sure you have a not null date

            $date_explode = explode(" - ", $this->fecha_hora_ejecucion);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha_hora_ejecucion', $date1, $date2]);
        }

        return $dataProvider;
    }
}
