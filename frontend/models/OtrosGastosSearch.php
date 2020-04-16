<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OtrosGastos;

/**
 * OtrosGastosSearch represents the model behind the search form of `frontend\models\OtrosGastos`.
 */
class OtrosGastosSearch extends OtrosGastos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'valor_unitario', 'cantidad_unitaria', 'vehiculo_id', 'tipo_gasto_id', 'tipo_descuento', 'cantidad_descuento', 'tipo_impuesto_id', 'usuario_id', 'proveedor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['factura', 'codigo_interno', 'fecha', 'observacion', 'creado_el', 'actualizado_el'], 'safe'],
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
     * Búsqueda otros gastos por vehiculo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOtrosGastosVehiculo($params){

        $query = OtrosGastos::find();

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
        $query = OtrosGastos::find()->select(['(sum(valor_unitario*cantidad_unitaria)-(sum(valor_unitario*cantidad_unitaria)*(cantidad_descuento/100))) as total_cost','otros_gastos.*'])->groupBy(['id']);

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
            'valor_unitario' => $this->valor_unitario,
            'cantidad_unitaria' => $this->cantidad_unitaria,
            'vehiculo_id' => $this->vehiculo_id,
            'tipo_gasto_id' => $this->tipo_gasto_id,
            'tipo_descuento' => $this->tipo_descuento,
            'cantidad_descuento' => $this->cantidad_descuento,
            'tipo_impuesto_id' => $this->tipo_impuesto_id,
            'usuario_id' => $this->usuario_id,
            'proveedor_id' => $this->proveedor_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'factura', $this->factura])
            ->andFilterWhere(['like', 'codigo_interno', $this->codigo_interno])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'valor_unitario', $this->valor_unitario]);
        
        if (!empty($this->fecha)) { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->fecha);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'fecha', $date1, $date2]);
        }
        return $dataProvider;
    }
}
