<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrdenesTrabajosRepuestos;

/**
 * OrdenesTrabajosRepuestosSearch represents the model behind the search form of `frontend\models\OrdenesTrabajosRepuestos`.
 */
class OrdenesTrabajosRepuestosSearch extends OrdenesTrabajosRepuestos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'orden_trabajo_id', 'repuesto_id', 'proveedor_id', 'costo_unitario', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
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
     * Búsqueda repuestos por ordenes
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOrdenesTrabajosRepuesto($params){

        $query = OrdenesTrabajosRepuestos::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'orden_trabajo_id' => $this->orden_trabajo_id,
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
    public function search($params, $idOrden)
    {
        $query = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $idOrden]);

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
            'orden_trabajo_id' => $this->orden_trabajo_id,
            'repuesto_id' => $this->repuesto_id,
            'proveedor_id' => $this->proveedor_id,
            'costo_unitario' => $this->costo_unitario,
            'empresa_id' => $this->empresa_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        return $dataProvider;
    }
}
