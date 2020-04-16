<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\VehiculosConductores;

/**
 * VehiculosConductoresSearch represents the model behind the search form of `frontend\models\VehiculosConductores`.
 */
class VehiculosConductoresSearch extends VehiculosConductores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado','vehiculo_id', 'conductor_id', 'dias_alerta', 'principal', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['fecha_1','fecha_2','fecha2_1','fecha2_2', 'fecha_desde', 'fecha_hasta', 'creado_el', 'actualizado_el'], 'safe'],
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


    public function searchFlotaConductores($params){
        $query = VehiculosConductores::find()->andFilterWhere(['vehiculo_id'=>@$_GET['idv']]);

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'vehiculo_id' => $this->vehiculo_id,
            'conductor_id' => $this->conductor_id, 
        ]);

        $query->andFilterWhere(['between', 'fecha_desde', $this->fecha_1, $this->fecha_2]);
        $query->andFilterWhere(['between', 'fecha_hasta', $this->fecha2_1, $this->fecha2_2]);

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
        $query = VehiculosConductores::find()->where(['vehiculo_id'=>$_GET['idv']]);

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
            'vehiculo_id' => $this->vehiculo_id,
            'conductor_id' => $this->conductor_id,
            'estado' => $this->estado,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
            'dias_alerta' => $this->dias_alerta,
            'principal' => $this->principal,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        return $dataProvider;
    }
}
