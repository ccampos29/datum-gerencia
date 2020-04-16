<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Trabajos;

/**
 * TrabajosSearch represents the model behind the search form of `frontend\models\Trabajos`.
 */
class TrabajosSearch extends Trabajos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado', 'tipo_mantenimiento_id', 'sistema_id', 'subsistema_id', 'cuenta_contable_id', 'periodico', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'observacion', 'codigo', 'creado_el', 'actualizado_el'], 'safe'],
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
    public function searchTrabajoTiposMantenimientos($params){

        $query = Trabajos::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'tipo_mantenimiento_id' => $this->tipo_mantenimiento_id,
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
        $query = Trabajos::find();

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
            'estado' => $this->estado,
            'tipo_mantenimiento_id' => $this->tipo_mantenimiento_id,
            'sistema_id' => $this->sistema_id,
            'subsistema_id' => $this->subsistema_id,
            'cuenta_contable_id' => $this->cuenta_contable_id,
            'periodico' => $this->periodico,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
