<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RepuestosInventariables;

/**
 * RepuestosInventariablesSearch represents the model behind the search form of `frontend\models\RepuestosInventariables`.
 */
class RepuestosInventariablesSearch extends RepuestosInventariables
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'repuesto_id', 'ubicacion_id', 'cantidad', 'valor_unitario', 'cantidad_minima', 'cantidad_maxima', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
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
     * Búsqueda repuestos por ubicacion
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRepuestosInventariables($params){

        $query = RepuestosInventariables::find();

        $dataProvider = $this->callingDataProvider($query,$params);

        $query->andFilterWhere([
            'ubicacion_id' => $this->ubicacion_id,
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
    public function search($params, $idRepuesto)
    {
        $query = RepuestosInventariables::find()->where(['repuesto_id' => $idRepuesto]);;

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
            'repuesto_id' => $this->repuesto_id,
            'ubicacion_id' => $this->ubicacion_id,
            'cantidad' => $this->cantidad,
            'valor_unitario' => $this->valor_unitario,
            'cantidad_minima' => $this->cantidad_minima,
            'cantidad_maxima' => $this->cantidad_maxima,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        return $dataProvider;
    }
}
