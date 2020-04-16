<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\CriteriosEvaluacionesDetalle;

/**
 * CriteriosEvaluacionesDetalleSearch represents the model behind the search form of `frontend\models\CriteriosEvaluacionesDetalle`.
 */
class CriteriosEvaluacionesDetalleSearch extends CriteriosEvaluacionesDetalle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_criterio_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['detalle', 'creado_el', 'actualizado_el'], 'safe'],
            [['rango', 'minimo', 'maximo'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        
        $query = CriteriosEvaluacionesDetalle::find()->where(['tipo_criterio_id'=>$_GET['idCriterio']]);

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
            'tipo_criterio_id' => $this->tipo_criterio_id,
            'rango' => $this->rango,
            'minimo' => $this->minimo,
            'maximo' => $this->maximo,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'detalle', $this->detalle]);

        return $dataProvider;
    }
}
