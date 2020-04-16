<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrdenesTrabajosTrabajos;

/**
 * OrdenesTrabajosTrabajosSearch represents the model behind the search form of `frontend\models\OrdenesTrabajosTrabajos`.
 */
class OrdenesTrabajosTrabajosSearch extends OrdenesTrabajosTrabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'orden_trabajo_id', 'trabajo_id', 'tipo_mantenimiento_id', 'costo_mano_obra', 'cantidad', 'empresa_id', 'creado_por', 'actualizado_por'], 'integer'],
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
     * Búsqueda trabajos por ordenes
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOrdenesTrabajosTrabajo($params){

        $query = OrdenesTrabajosTrabajos::find();

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
        $query = OrdenesTrabajosTrabajos::find()->where(['orden_trabajo_id' => $idOrden]);

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
            'trabajo_id' => $this->trabajo_id,
            'tipo_mantenimiento_id' => $this->tipo_mantenimiento_id,
            'costo_mano_obra' => $this->costo_mano_obra,
            'cantidad' => $this->cantidad,
            'empresa_id' => $this->empresa_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        return $dataProvider;
    }
}
