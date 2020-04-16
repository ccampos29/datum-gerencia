<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PropiedadesTrabajos;

/**
 * PropiedadesTrabajosSearch represents the model behind the search form of `frontend\models\PropiedadesTrabajos`.
 */
class PropiedadesTrabajosSearch extends PropiedadesTrabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_vehiculo_id', 'repuesto_id', 'cantidad_repuesto', 'duracion', 'costo_mano_obra', 'cantidad_trabajo', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
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
    public function searchCostoTrabajosTipoVehiculo($params){

        $query = PropiedadesTrabajos::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
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
    public function search($params, $idTrabajo)
    {
        $query = PropiedadesTrabajos::find()->where(['trabajo_id' => $idTrabajo]);

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
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
            'repuesto_id' => $this->repuesto_id,
            'trabajo_id' => $this->trabajo_id,
            'duracion' => $this->duracion,
            'costo_mano_obra' => $this->costo_mano_obra,
            'cantidad_trabajo' => $this->cantidad_trabajo,
            'cantidad_repuesto' => $this->cantidad_repuesto,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        return $dataProvider;
    }
}
